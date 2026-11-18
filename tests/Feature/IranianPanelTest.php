<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarTransaction;
use App\Models\Expense;
use App\Models\House;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Person;
use App\Models\HouseRent;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * تست صفحات پنل با تم جدید و اصلاحات امنیتی
 */
class IranianPanelTest extends TestCase
{
    use RefreshDatabase;

    private function master(): User
    {
        return User::factory()->create(['role' => 'master', 'is_active' => true, 'phone' => '09120000000']);
    }

    private function accountant(array $attrs = []): User
    {
        return User::factory()->create(array_merge(['role' => 'accountant', 'is_active' => true, 'phone' => '0912'.random_int(1000000, 9999999)], $attrs));
    }

    private function seedData(User $owner): array
    {
        $car = Car::create(['name' => 'پراید', 'owner_name' => 'علی', 'owner_phone' => '0912', 'user_id' => $owner->id, 'status' => 'active']);
        $house = House::create(['name' => 'آپارتمان', 'owner_name' => 'رضا', 'owner_phone' => '0913', 'address' => 'تهران', 'user_id' => $owner->id, 'status' => 'active']);
        $person = Person::create(['name' => 'حسن', 'user_id' => $owner->id, 'status' => 'active']);
        $org = Organization::create(['name' => 'بانک ملی', 'user_id' => $owner->id, 'status' => 'active']);
        $tx = CarTransaction::create(['car_id' => $car->id, 'user_id' => $owner->id, 'type' => 'income', 'amount' => 1500000, 'transaction_date' => '1404/06/25']);
        Expense::create(['title' => 'خرید', 'type' => 'expense', 'amount' => 20000, 'transaction_date' => '1404/06/20', 'user_id' => $owner->id]);
        Todo::create(['user_id' => $owner->id, 'title' => 'پیگیری چک']);

        return compact('car', 'house', 'person', 'org', 'tx');
    }

    public function test_landing_and_login_pages_render_with_new_brand(): void
    {
        $this->get('/')->assertOk()->assertSee('ایرانیان')->assertSee('css/iranian.css', false)->assertDontSee('صبا');
        $this->get('/login')->assertOk()->assertSee('ورود به حساب')->assertSee('ایرانیان');
        $this->get('/forgot-password')->assertOk()->assertSee('فراموشی رمز عبور');
    }

    public function test_master_can_open_every_panel_page(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);
        $acc = $this->accountant();

        $this->actingAs($master);

        // ثبت اجاره و وام از مسیر واقعی تا اقساط ساخته شوند
        $this->post(route('houses.rents.store', $d['house']), ['type' => 'rent_out', 'monthly_amount' => 5000000, 'start_date' => '1404/01/01', 'total_months' => 3])->assertRedirect();
        $this->post(route('organizations.loans.store', $d['org']), ['type' => 'loan_taken', 'total_amount' => 30000000, 'monthly_amount' => 10000000, 'start_date' => '1404/01/01', 'total_months' => 3])->assertRedirect();
        $rent = $d['house']->rents()->first();
        $loan = $d['org']->loans()->first();

        $urls = [
            route('dashboard'),
            route('profile.edit'),
            route('master.users'), route('master.users.create'), route('master.users.edit', $acc),
            route('permissions.index', $acc), route('permissions.edit', $acc),
            route('master.todos.index'), route('master.todos.create'), route('master.todos.edit', Todo::first()),
            route('cars.index'), route('cars.create'),
            route('cars.transactions.index', $d['car']), route('cars.transactions.create', $d['car']),
            route('houses.index'), route('houses.create'), route('houses.edit', $d['house']),
            route('houses.transactions.index', $d['house']), route('houses.transactions.create', $d['house']),
            route('houses.rents.index', $d['house']), route('houses.rents.create', $d['house']), route('houses.rents.edit', [$d['house'], $rent]),
            route('persons.index'), route('persons.create'), route('persons.edit', $d['person']),
            route('persons.transactions.index', $d['person']), route('persons.transactions.create', $d['person']),
            route('organizations.index'), route('organizations.create'), route('organizations.edit', $d['org']),
            route('organizations.transactions.index', $d['org']), route('organizations.transactions.create', $d['org']),
            route('organizations.loans.index', $d['org']), route('organizations.loans.create', $d['org']), route('organizations.loans.edit', [$d['org'], $loan]),
            route('expenses.index'), route('expenses.create'), route('expenses.edit', Expense::first()),
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertOk()->assertSee('data-layout="panel"', false);
        }
    }

    public function test_accountant_dashboard_and_allowed_module(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);
        $acc = $this->accountant();
        Permission::create(['user_id' => $acc->id, 'module' => 'persons', 'access' => true, 'item_ids' => null]);

        $this->actingAs($acc)->get(route('dashboard'))->assertOk()->assertSee('بخش‌های قابل دسترس')->assertSee('اشخاص');
        $this->actingAs($acc)->get(route('persons.transactions.index', $d['person']))->assertOk();
        $this->actingAs($acc)->get(route('master.users'))->assertForbidden();
    }

    public function test_nested_transaction_must_belong_to_parent(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);
        $acc = $this->accountant();

        // حسابدار فقط به خودروی دوم دسترسی دارد
        $otherCar = Car::create(['name' => 'پژو', 'owner_name' => 'x', 'owner_phone' => '1', 'user_id' => $master->id, 'status' => 'active']);
        Permission::create(['user_id' => $acc->id, 'module' => 'cars', 'access' => true, 'item_ids' => [$otherCar->id]]);

        // تلاش برای حذف تراکنش خودروی اول از مسیر خودروی دوم
        $this->actingAs($acc)
            ->delete(route('cars.transactions.destroy', [$otherCar, $d['tx']]))
            ->assertNotFound();

        $this->assertDatabaseHas('car_transactions', ['id' => $d['tx']->id, 'deleted_at' => null]);
    }

    public function test_receipt_upload_does_not_keep_client_filename(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);

        $file = UploadedFile::fake()->image('shell.php.png', 50, 50);

        $this->actingAs($master)->post(route('cars.transactions.store', $d['car']), [
            'type' => 'expense', 'amount' => 1000, 'transaction_date' => '1404/06/25', 'receipt_image' => $file,
        ])->assertRedirect();

        $path = CarTransaction::latest('id')->first()->receipt_image;
        $this->assertStringNotContainsString('shell', $path);
        $this->assertStringEndsWith('.png', $path);
        File::delete(public_path($path));
    }

    public function test_logout_requires_post_and_inactive_users_are_logged_out(): void
    {
        $acc = $this->accountant();

        $this->actingAs($acc)->get('/logout')->assertStatus(405);
        $this->assertAuthenticated();

        $acc->update(['is_active' => false]);
        $this->actingAs($acc)->get(route('dashboard'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_login_is_rate_limited(): void
    {
        $acc = $this->accountant();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['login' => $acc->email, 'password' => 'wrong']);
        }

        $this->post('/login', ['login' => $acc->email, 'password' => 'password'])->assertStatus(429);
        $this->assertGuest();
    }

    public function test_car_edit_and_car_transaction_edit_work(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);
        $this->actingAs($master);

        $this->get(route('cars.edit', $d['car']))->assertOk()->assertSee('ویرایش خودرو');
        $this->put(route('cars.update', $d['car']), ['name' => 'پراید نقره‌ای', 'owner_name' => 'علی', 'owner_phone' => '0912', 'status' => 'active'])->assertRedirect();
        $this->assertSame('پراید نقره‌ای', $d['car']->fresh()->name);

        $this->get(route('cars.transactions.edit', [$d['car'], $d['tx']]))->assertOk()->assertSee('1404/06/25');
        $this->put(route('cars.transactions.update', [$d['car'], $d['tx']]), ['type' => 'expense', 'amount' => 2000, 'transaction_date' => '1404/07/01'])->assertRedirect();
        $this->assertSame('1404/07/01', $d['tx']->fresh()->transaction_date);
    }

    public function test_accountant_without_access_sees_empty_lists_and_cannot_create(): void
    {
        $this->seedData($this->master());
        $acc = $this->accountant();
        $this->actingAs($acc);

        foreach (['cars', 'houses', 'persons', 'organizations'] as $module) {
            $this->get(route($module . '.index'))->assertOk();
            $this->get(route($module . '.create'))->assertForbidden();
        }
        $this->post(route('cars.store'), ['name' => 'x', 'owner_name' => 'y', 'owner_phone' => '1'])->assertForbidden();
        $this->get(route('expenses.index'))->assertForbidden();

        Permission::create(['user_id' => $acc->id, 'module' => 'cars', 'access' => true, 'item_ids' => null]);
        $this->get(route('cars.create'))->assertOk();
    }

    public function test_rent_update_keeps_paid_installments_and_rent_payment_can_be_cancelled(): void
    {
        $master = $this->master();
        $d = $this->seedData($master);
        $this->actingAs($master);

        $this->post(route('houses.rents.store', $d['house']), ['type' => 'rent_out', 'monthly_amount' => 1000, 'start_date' => '1404/01/01', 'total_months' => 3]);
        $rent = HouseRent::first();
        $first = $rent->installments()->where('installment_number', 1)->first();
        $this->post(route('houses.rents.pay-installment', [$d['house'], $rent, $first]), ['paid_date' => '1404/01/02']);
        $this->assertTrue($first->fresh()->is_paid);

        // تغییر مبلغ و مدت: قسط پرداخت‌شده باید بماند
        $this->put(route('houses.rents.update', [$d['house'], $rent]), ['type' => 'rent_out', 'monthly_amount' => 2000, 'start_date' => '1404/01/01', 'total_months' => 5])->assertRedirect();
        $rent->refresh();
        $this->assertSame(5, $rent->installments()->count());
        $this->assertTrue($rent->installments()->where('installment_number', 1)->first()->is_paid);
        $this->assertEquals(2000, $rent->installments()->where('installment_number', 2)->first()->amount);

        // کم کردن مدت به کمتر از قسط پرداخت‌شده مجاز نیست
        $this->post(route('houses.rents.pay-installment', [$d['house'], $rent, $rent->installments()->where('installment_number', 4)->first()]), ['paid_date' => '1404/04/02']);
        $this->put(route('houses.rents.update', [$d['house'], $rent]), ['type' => 'rent_out', 'monthly_amount' => 2000, 'start_date' => '1404/01/01', 'total_months' => 2])->assertSessionHasErrors('total_months');

        // لغو پرداخت قسط اجاره از صفحه اجاره‌ها
        $paid = $rent->installments()->where('installment_number', 1)->first();
        $this->get(route('houses.rents.index', $d['house']))->assertSee(route('houses.rents.cancel-installment', [$d['house'], $rent, $paid]), false);
        $this->post(route('houses.rents.cancel-installment', [$d['house'], $rent, $paid]))->assertRedirect();
        $this->assertFalse($paid->fresh()->is_paid);
    }

    public function test_permission_editor_lists_items_of_every_module(): void
    {
        $master = $this->master();
        $this->seedData($master);
        $acc = $this->accountant();

        $this->actingAs($master)->get(route('permissions.edit', $acc))
            ->assertOk()->assertSee('پراید')->assertSee('آپارتمان')->assertSee('حسن')->assertSee('بانک ملی');
    }

    public function test_todo_accepts_persian_due_date(): void
    {
        $this->actingAs($this->master())
            ->post(route('master.todos.store'), ['title' => 'چک', 'due_date' => '1404/06/25'])
            ->assertRedirect();

        $this->assertDatabaseHas('todos', ['title' => 'چک', 'due_date' => '1404/06/25']);
    }

    public function test_create_master_command(): void
    {
        $this->artisan('app:create-master')
            ->expectsQuestion('ایمیل مدیر', 'boss@example.com')
            ->expectsQuestion('نام و نام خانوادگی', 'مدیر')
            ->expectsQuestion('شماره موبایل (برای ورود با موبایل)', '09125555555')
            ->expectsQuestion('رمز عبور (حداقل ۸ کاراکتر)', 'Secret123')
            ->expectsQuestion('تکرار رمز عبور', 'Secret123')
            ->assertSuccessful();

        $user = User::firstWhere('email', 'boss@example.com');
        $this->assertTrue($user->isMaster());

        $this->post('/login', ['login' => '09125555555', 'password' => 'Secret123'])->assertRedirect(route('dashboard', absolute: false));
    }
}
