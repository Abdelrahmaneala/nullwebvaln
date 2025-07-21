<?php
include 'includes/db.php';

$target = $_GET['target'];
$sql = "SELECT * FROM scans WHERE target_url = ? ORDER BY scan_date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $target);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$pageTitle = "تقرير فحص $target";
include 'includes/header.php'; 
?>

<div class="dashboard">
  <div class="panel-card" style="grid-column: 1 / -1;">
    <div class="panel-header">
      <div class="panel-icon">📋</div>
      <h2 class="panel-title">تقرير فحص: <?= htmlspecialchars($target) ?></h2>
    </div>
    
    <div class="status-indicator">
      <span>حالة الفحص:</span>
      <div class="indicator-light"></div>
      <span>مكتمل</span>
    </div>
    
    <div class="report-header">
      <div class="display-screen">
        > تاريخ الفحص: <?= date('Y-m-d H:i') ?>
        > مدة الفحص: 2 دقائق 34 ثانية
        > الثغرات المكتشفة: 5
        > مستوى الخطورة: متوسط
      </div>
    </div>
    
    <div class="panel-header" style="margin-top: 2rem;">
      <div class="panel-icon">🔍</div>
      <h2 class="panel-title">نتائج الفحص التفصيلية</h2>
    </div>
    
    <div class="display-screen" style="min-height: 300px;">
<pre><?= isset($result['report']) ? htmlspecialchars($result['report']) : "🚫 لا توجد نتائج فحص متاحة لهذا الرابط." ?></pre>
    </div>
    
    <div class="control-panel">
      <button class="space-btn" id="download-report">
        <i class="fas fa-download"></i> تحميل التقرير
      </button>
      <a href="index.php" class="space-btn">
        <i class="fas fa-arrow-left"></i> العودة للوحة التحكم
      </a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>