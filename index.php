<?php
$pageTitle = "NullSpecter - فحص الأمان";
include 'includes/header.php';
?>

<div class="dashboard">
  <div class="panel-card">
    <div class="panel-header">
      <i class="fas fa-radar panel-icon"></i>
      <h2 class="panel-title">فحص موقع ويب</h2>
    </div>
    
    <form id="scan-form">
      <div class="form-group">
        <label for="target-url">رابط الموقع:</label>
        <input 
          type="url" 
          id="target-url" 
          name="url"
          placeholder="https://example.com"
          required
        >
      </div>
      
      <button type="submit" id="start-scan" class="space-btn">
        <i class="fas fa-play"></i> بدء الفحص
      </button>
    </form>
  </div>
  
  <div class="panel-card">
    <div class="panel-header">
      <i class="fas fa-file-alt panel-icon"></i>
      <h2 class="panel-title">تقرير الفحص</h2>
    </div>
    
    <div class="display-screen">
      <pre id="scan-report">سيظهر التقرير هنا بعد الفحص...</pre>
    </div>
    
    <button id="download-report" class="space-btn">
      <i class="fas fa-download"></i> تحميل التقرير
    </button>
  </div>
</div>

<?php include 'includes/footer.php'; ?>