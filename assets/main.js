
document.addEventListener('DOMContentLoaded', () => {
  console.log("نظام NullSpecter جاهز للإقلاع! 🚀");

  // تأثيرات النجوم
  createStars();

  // تحميل التقارير
  document.getElementById('download-report')?.addEventListener('click', downloadReport);

  // تأثيرات لوحة التحكم
  initDashboardEffects();

  // إدارة عملية الفحص
  const scanForm = document.getElementById('scan-form');
  if (scanForm) {
    scanForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const url = document.getElementById('target-url').value;
      const scanBtn = document.getElementById('start-scan');

      // تعطيل الزر أثناء الفحص
      scanBtn.disabled = true;
      scanBtn.textContent = 'جارٍ الفحص...';

      try {
        const response = await fetch('scan.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `url=${encodeURIComponent(url)}`
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        const result = await response.text();
        document.getElementById('scan-report').textContent = result;

        // إشعار بنجاح الفحص
        showNotification('✅ تم الانتهاء من الفحص بنجاح');

      } catch (error) {
        console.error('Error:', error);
        showNotification('❌ فشل في عملية الفحص');
      } finally {
        scanBtn.disabled = false;
        scanBtn.textContent = 'بدء الفحص';
      }
    });
  }
});

function createStars() {
  const space = document.querySelector('.dashboard');
  if (!space) return;

  for (let i = 0; i < 100; i++) {
    const star = document.createElement('div');
    star.classList.add('star');
    star.style.left = `${Math.random() * 100}%`;
    star.style.top = `${Math.random() * 100}%`;
    star.style.animationDelay = `${Math.random() * 5}s`;
    space.appendChild(star);
  }
}

function downloadReport() {
  const reportContent = document.getElementById('scan-report').innerText;
  if (!reportContent) return;

  const blob = new Blob([reportContent], { type: 'text/plain' });
  const url = URL.createObjectURL(blob);

  const a = document.createElement('a');
  a.href = url;
  a.download = `nullspector-report-${Date.now()}.txt`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);

  // تأثير الإشعار
  showNotification('✅ تم بدء تحميل التقرير');
}

function initDashboardEffects() {
  const cards = document.querySelectorAll('.panel-card');
  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
  });
}

function showNotification(message) {
  const notification = document.createElement('div');
  notification.textContent = message;
  notification.classList.add('scan-notification');
  document.body.appendChild(notification);

  setTimeout(() => {
    notification.remove();
  }, 3000);
}
