/* ===== SCANBOX.RO - SHARED JAVASCRIPT ===== */

// Navbar scroll effect
document.addEventListener('DOMContentLoaded', () => {
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
  }

  // Hamburger menu
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
      });
    });
  }

  // Mobile dropdown toggle
  const mobileDropdownToggle = document.getElementById('mobileDropdownToggle');
  const mobileDropdownItems = document.getElementById('mobileDropdownItems');
  if (mobileDropdownToggle && mobileDropdownItems) {
    mobileDropdownToggle.addEventListener('click', () => {
      mobileDropdownItems.classList.toggle('active');
      const svg = mobileDropdownToggle.querySelector('svg');
      if (mobileDropdownItems.classList.contains('active')) {
        svg.style.transform = 'rotate(180deg)';
      } else {
        svg.style.transform = 'rotate(0deg)';
      }
    });
  }

  // Intersection Observer for fade-in animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.stat-item, .service-card, .step-item, .special-card, .testimonial-slider, .portfolio-card, .testimonial-content, .cta-banner, .blog-card, .pricing-card, .project-card, .content-grid, .gallery-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.7s ease, transform 0.7s ease';
    observer.observe(el);
  });

  // Stagger delays for grid items
  const stagger = (selector, delay = 0.1) => {
    document.querySelectorAll(selector).forEach((el, i) => {
      el.style.transitionDelay = `${i * delay}s`;
    });
  };
  stagger('.stats-grid .stat-item');
  stagger('.services-grid .service-card');
  stagger('.services-bottom-row .service-card');
  stagger('.steps-wrapper .step-item', 0.15);
  stagger('.special-grid .special-card', 0.15);
  stagger('.portfolio-grid .portfolio-card');
  stagger('.blog-grid .blog-card');
  stagger('.pricing-grid .pricing-card', 0.15);
  stagger('.gallery-grid .gallery-item', 0.05);

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"], button[onclick*="scrollIntoView"]').forEach(anchor => {
    if (anchor.tagName === 'A') {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });

  // Testimonials slider
  initTestimonialsSlider();

  // Contact form
  initContactForm();

  // Counter animation
  initCounters();

  // Active nav link
  setActiveNavLink();

  // FAQ accordion
  initFaq();
});

// Testimonials slider
function initTestimonialsSlider() {
  const slides = document.querySelectorAll('.testimonial-slide');
  const dots = document.querySelectorAll('.testimonial-dot');
  if (!slides.length) return;

  let current = 0;
  let slideInterval;

  const show = (index) => {
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));
    slides[index].classList.add('active');
    if (dots[index]) dots[index].classList.add('active');
    current = index;
  };

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      clearInterval(slideInterval);
      show(parseInt(dot.dataset.index));
      slideInterval = setInterval(() => show((current + 1) % slides.length), 6000);
    });
  });

  slideInterval = setInterval(() => show((current + 1) % slides.length), 6000);
  show(0);
}

// Contact form submission
function initContactForm() {
  const form = document.getElementById('contactForm');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'Se trimite...';
    btn.disabled = true;

    const data = Object.fromEntries(new FormData(form));

    try {
      const res = await fetch('/api/contact-submit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const text = await res.text();
      console.log('Server response:', res.status, text);
      let result;
      try { result = JSON.parse(text); } catch (e) {
        console.error('Invalid JSON:', text);
        throw new Error('Răspuns invalid');
      }
      if (res.ok && result.success) {
        btn.innerHTML = 'Trimis cu succes! ✓';
        btn.style.background = 'linear-gradient(90deg, #04B494, #039B7E)';
        form.reset();
        setTimeout(() => { btn.innerHTML = originalText; btn.disabled = false; }, 3000);
      } else {
        const errMsg = result.errors ? result.errors.join(' ') : (result.message || 'Eroare.');
        console.error('Validation errors:', result);
        btn.innerHTML = errMsg;
        btn.style.background = '#ef4444';
        setTimeout(() => { btn.innerHTML = originalText; btn.disabled = false; btn.style.background = ''; }, 5000);
      }
    } catch (err) {
      console.error('Contact form error:', err);
      btn.innerHTML = 'Eroare de conexiune. Încercați din nou.';
      btn.style.background = '#ef4444';
      setTimeout(() => { btn.innerHTML = originalText; btn.disabled = false; btn.style.background = ''; }, 4000);
    }
  });
}

// Counter animation on scroll
function initCounters() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const animate = (el) => {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const duration = 2000;
    const start = performance.now();

    const step = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(target * eased) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animate(entry.target);
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(c => obs.observe(c));
}

// Set active nav link based on current page
function setActiveNavLink() {
  const path = window.location.pathname;
  document.querySelectorAll('.navbar-links a, .mobile-menu a').forEach(link => {
    const href = link.getAttribute('href');
    if (!href || href === '#' || href.startsWith('#')) return;
    if (path === '/' && href === '/') {
      link.classList.add('active');
    } else if (href !== '/' && path.startsWith(href)) {
      link.classList.add('active');
    }
  });
}

// FAQ accordion toggle
function initFaq() {
  document.querySelectorAll('.faq-toggle').forEach(btn => {
    btn.addEventListener('click', () => btn.parentElement.classList.toggle('open'));
  });
}
