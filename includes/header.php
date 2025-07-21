<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NullSpecter' ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/contact.css"> <!-- إضافة ملف أنماط الاتصال -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- النجوم المتحركة -->
    <div class="star-field"></div>
    
    <div class="dashboard">
        <div class="spaceship-logo floating">
            <h1>NullSpecter</h1>
        </div>
        
        <nav class="panel-card">
            <div class="logo">
                <i class="fas fa-ghost panel-icon"></i>
                <span class="panel-title">NullSpecter</span>
            </div>
            <ul class="control-panel">
                <li><a href="index.php" class="space-btn"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li><a href="about.php" class="space-btn"><i class="fas fa-info-circle"></i> عن التطبيق</a></li>
                <li><a href="contact.php" class="space-btn"><i class="fas fa-envelope"></i> التواصل</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">