document.addEventListener('DOMContentLoaded', function () {
  // Mobile nav toggle
  var toggle = document.getElementById('navToggle');
  var links = document.getElementById('navLinks');
  if (toggle && links) {
    toggle.addEventListener('click', function () {
      links.classList.toggle('is-open');
    });
    // Close on link click
    links.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        links.classList.remove('is-open');
      });
    });
  }

  // Sticky header shadow on scroll
  var header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 10) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

  // Intersection Observer for fade-in animations
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(function (el) {
      el.style.animationPlayState = 'paused';
      observer.observe(el);
    });
  }

  // Pricing toggle
  var billingToggle = document.getElementById('billing-toggle');
  if (billingToggle) {
    billingToggle.addEventListener('change', function () {
      var annual = this.checked;
      document.querySelectorAll('.price-monthly').forEach(function (el) {
        el.style.display = annual ? 'none' : 'inline';
      });
      document.querySelectorAll('.price-annual').forEach(function (el) {
        el.style.display = annual ? 'inline' : 'none';
      });
      document.querySelectorAll('.price-cycle').forEach(function (el) {
        el.textContent = annual ? '/month (billed annually)' : '/month';
      });
      var labelM = document.getElementById('label-monthly');
      var labelA = document.getElementById('label-annual');
      if (labelM) {
        labelM.style.fontWeight = annual ? '500' : '600';
        labelM.style.color = annual ? 'var(--color-text-muted)' : 'var(--color-primary)';
      }
      if (labelA) {
        labelA.style.fontWeight = annual ? '600' : '500';
        labelA.style.color = annual ? 'var(--color-primary)' : 'var(--color-text-muted)';
      }
    });
  }
});
