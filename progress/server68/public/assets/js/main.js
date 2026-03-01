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

  // Intersection Observer for fade-in animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.stat-item, .service-card, .step-item, .portfolio-card, .testimonial-content, .cta-banner, .blog-card, .pricing-card, .project-card, .content-grid, .gallery-item').forEach(el => {
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
  stagger('.portfolio-grid .portfolio-card');
  stagger('.blog-grid .blog-card');
  stagger('.pricing-grid .pricing-card', 0.15);
  stagger('.gallery-grid .gallery-item', 0.05);

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href === '#') return;
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  // Testimonials slider
  initTestimonialsSlider();

  // Contact form
  initContactForm();

  // Counter animation
  initCounters();

  // Active nav link
  setActiveNavLink();
});

// Testimonials slider
function initTestimonialsSlider() {
  const slides = document.querySelectorAll('.testimonial-slide');
  const dots = document.querySelectorAll('.testimonials-dots button');
  if (!slides.length) return;

  let current = 0;
  const show = (index) => {
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));
    slides[index].classList.add('active');
    if (dots[index]) dots[index].classList.add('active');
    current = index;
  };

  dots.forEach((dot, i) => dot.addEventListener('click', () => show(i)));
  setInterval(() => show((current + 1) % slides.length), 6000);
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
      const res = await fetch('https://fast-coding-agency--fast-coding-d1143.europe-west4.hosted.app/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      if (res.ok) {
        btn.innerHTML = 'Trimis cu succes! ✓';
        btn.style.background = 'linear-gradient(90deg, #04B494, #039B7E)';
        form.reset();
        setTimeout(() => { btn.innerHTML = originalText; btn.disabled = false; }, 3000);
      } else { throw new Error(); }
    } catch {
      btn.innerHTML = 'Eroare. Încercați din nou.';
      btn.style.background = '#ef4444';
      setTimeout(() => { btn.innerHTML = originalText; btn.disabled = false; btn.style.background = ''; }, 3000);
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
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.navbar-links a, .mobile-menu a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (href === path || (path === 'index.html' && href === './'))) {
      link.classList.add('active');
    }
  });
}
