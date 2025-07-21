document.addEventListener('DOMContentLoaded', () => {
  // إنشاء النجوم
  createStars();
  
  // إدارة نموذج الاتصال
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      showNotification('🚀 تم إرسال رسالتك بنجاح!');
      contactForm.reset();
    });
  }
  
  // إضافة تأثيرات للبطاقات عند تحرك الماوس
  initCardEffects();
  
  // إضافة زر العودة
  initBackButton();
});

function createStars() {
  const starField = document.querySelector('.star-field');
  if (!starField) return;
  
  // إزالة النجوم الحالية إذا وجدت
  starField.innerHTML = '';
  
  for (let i = 0; i < 150; i++) {
    const star = document.createElement('div');
    star.classList.add('star');
    star.style.left = `${Math.random() * 100}%`;
    star.style.top = `${Math.random() * 100}%`;
    star.style.animationDelay = `${Math.random() * 5}s`;
    starField.appendChild(star);
  }
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

function initCardEffects() {
  const cards = document.querySelectorAll('.panel-card, .contact-channel');
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

function initBackButton() {
  const backBtn = document.querySelector('.back-btn');
  if (backBtn) {
    backBtn.addEventListener('click', (e) => {
      e.preventDefault();
      window.history.back();
    });
  }
}