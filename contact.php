<?php 
$pageTitle = "اتصل بنا";
include 'includes/header.php'; 
?>

<div class="dashboard">
    <div class="panel-card floating" style="max-width: 800px; margin: 0 auto;">
        <div class="panel-header">
            <div class="panel-icon">🚀</div>
            <h2 class="panel-title">اتصل بفريق NullSpecter</h2>
        </div>
        
        <div class="contact-grid">
            <div class="contact-channel">
                <div class="channel-icon"><i class="fas fa-envelope"></i></div>
                <h3>البريد الإلكتروني</h3>
                <p>تواصل معنا عبر البريد الإلكتروني</p>
                <a href="mailto:boodapro540@gmail.com" class="space-btn channel-btn">
                    <i class="fas fa-paper-plane"></i> boodapro540@gmail.com
                </a>
            </div>
            
            <div class="contact-channel">
                <div class="channel-icon"><i class="fab fa-github"></i></div>
                <h3>مستودع GitHub</h3>
                <p>تابع مشاريعنا المفتوحة المصدر</p>
                <a href="https://github.com/Abdelrahmaneala" target="_blank" class="space-btn channel-btn">
                    <i class="fab fa-github"></i> Abdelrahmaneala
                </a>
            </div>
        </div>
        
        <div class="panel-header" style="margin-top: 2rem;">
            <div class="panel-icon">📡</div>
            <h2 class="panel-title">أرسل رسالة مباشرة</h2>
        </div>
        
        <form class="contact-form" id="contact-form">
            <div class="form-group">
                <label for="name"><i class="fas fa-user-astronaut"></i> الاسم</label>
                <input type="text" id="name" name="name" placeholder="اسمك الكامل" required class="space-input">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                <input type="email" id="email" name="email" placeholder="بريدك الإلكتروني" required class="space-input">
            </div>
            <div class="form-group">
                <label for="message"><i class="fas fa-comment-alt"></i> الرسالة</label>
                <textarea id="message" name="message" placeholder="اكتب رسالتك هنا..." rows="5" required class="space-input space-textarea"></textarea>
            </div>
            <button type="submit" class="space-btn send-btn">
                <i class="fas fa-paper-plane"></i> إرسال الرسالة
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>