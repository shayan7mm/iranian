<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * تاریخ سررسید کارها به‌صورت متن شمسی (مثل 1404/06/25) وارد می‌شود؛
 * ستون date در MySQL این مقدار را نمی‌پذیرد، پس به string تبدیل می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->string('due_date', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->date('due_date')->nullable()->change();
        });
    }
};
