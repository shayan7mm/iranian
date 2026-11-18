/* سیستم حسابداری ایرانیان — اسکریپت‌های عمومی پنل */
(function () {
  'use strict';
  // باز و بسته کردن سایدبار در موبایل
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-toggle-sidebar]')) {
      document.body.classList.toggle('sidebar-open');
    } else if (e.target.closest('[data-close-sidebar]')) {
      document.body.classList.remove('sidebar-open');
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') document.body.classList.remove('sidebar-open');
  });
  // تأیید قبل از ارسال فرم‌های حساس (حذف، آرشیو، لغو)
  document.addEventListener('submit', function (e) {
    var msg = e.target.getAttribute('data-confirm');
    if (msg && !window.confirm(msg)) e.preventDefault();
  });
  // جداکننده سه‌رقمی زنده برای فیلدهای مبلغ (نمایشی؛ مقدار عددی ارسال می‌شود)
  document.querySelectorAll('[data-amount]').forEach(function (input) {
    var out = document.querySelector('[data-amount-preview="' + input.name + '"]');
    if (!out) return;
    var render = function () {
      var v = String(input.value || '').replace(/[^\d]/g, '');
      out.textContent = v ? Number(v).toLocaleString('fa-IR') + ' تومان' : '';
    };
    input.addEventListener('input', render);
    render();
  });
})();
