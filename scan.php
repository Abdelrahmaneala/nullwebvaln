<?php
// زيادة وقت التنفيذ إلى 120 ثانية
set_time_limit(120);

// تضمين الملفات المطلوبة
require_once 'includes/functions.php';
require_once 'includes/db.php';

// التحقق من وجود الرابط والتحقق من صحته
$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo "❌ رابط غير صالح.";
    exit;
}

try {
    // تشغيل الفحص الحقيقي
    $report = run_real_scan($url);

    // حفظ التقرير في قاعدة البيانات
    $scan_id = save_report($conn, $url, $report);

    // إرجاع التقرير كنص عادي
    header('Content-Type: text/plain; charset=utf-8');
    echo $report;

} catch (Exception $e) {
    http_response_code(500);
    echo "❌ حدث خطأ أثناء الفحص: " . $e->getMessage();
}
?>