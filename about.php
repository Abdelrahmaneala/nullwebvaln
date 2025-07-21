<?php 
$pageTitle = "معلومات سفينة NullSpecter";
include 'includes/header.php'; 
?>

<div class="dashboard">
  <div class="panel-card floating">
    <div class="panel-header">
      <div class="panel-icon">🚀</div>
      <h2 class="panel-title">مواصفات سفينة الفحص NullSpecter</h2>
    </div>
    
    <div class="display-screen">
      > الطراز: NS-X2023
      > السرعة: فحص 3 مواقع/ثانية
      > التسليح: 28 أداة كشف ثغرات
      > الدرع: تشفير AES-256
      > تاريخ الإطلاق: 2023
    </div>
    
    <div class="panel-header" style="margin-top: 2rem;">
      <div class="panel-icon">🛡️</div>
      <h2 class="panel-title">أنظمة الكشف</h2>
    </div>
    
    <div class="features">
      <div class="feature">
        <i class="fas fa-bug"></i>
        <h3>كاشف ثغرات XSS</h3>
      </div>
      <div class="feature">
        <i class="fas fa-mouse-pointer"></i>
        <h3>نظام منع Clickjacking</h3>
      </div>
      <div class="feature">
        <i class="fas fa-shield-alt"></i>
        <h3>حماية ضد SQL Injection</h3>
      </div>
      <div class="feature">
        <i class="fas fa-lock"></i>
        <h3>ماسح SSL/TLS</h3>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>