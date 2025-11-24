document.addEventListener('DOMContentLoaded', function () {
  // Smooth scrolling for nav links
  const navLinks = document.querySelectorAll('nav ul li a');
  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const targetId = this.getAttribute('href').substring(1);
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
        window.scrollTo({
          top: targetSection.offsetTop - 70, // adjust for sticky header height
          behavior: 'smooth'
        });
      }
    });
  });

  // Simple contact form validation
  const form = document.querySelector('form');
  form.addEventListener('submit', function (e) {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    if (!nameInput.value.trim()) {
      alert('Please enter your name.');
      nameInput.focus();
      e.preventDefault();
      return;
    }

    if (!emailInput.value.trim()) {
      alert('Please enter your email.');
      emailInput.focus();
      e.preventDefault();
      return;
    } else {
      // Basic email format validation
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      if (!emailPattern.test(emailInput.value.trim().toLowerCase())) {
        alert('Please enter a valid email address.');
        emailInput.focus();
        e.preventDefault();
        return;
      }
    }

    if (!messageInput.value.trim()) {
      alert('Please enter your message.');
      messageInput.focus();
      e.preventDefault();
      return;
    }
  });

  // Highlight nav links on scroll
  const sections = document.querySelectorAll('main section');
  const navItems = document.querySelectorAll('nav ul li a');

  window.addEventListener('scroll', function () {
    let current = '';
    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

    sections.forEach(section => {
      if (scrollPosition >= section.offsetTop - 80) {
        current = section.getAttribute('id');
      }
    });

    navItems.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href').substring(1) === current) {
        link.classList.add('active');
      }
    });
  });

  // Mobile menu toggle (optional: you can add a button in your header to use this)
  // Add this HTML snippet inside <header> if you want:
  /*
    <button id="menu-toggle" aria-label="Toggle navigation menu">&#9776;</button>
  */
  // Add this JS for toggle:
  const menuToggle = document.getElementById('menu-toggle');
  if (menuToggle) {
    const navUl = document.querySelector('nav ul');
    menuToggle.addEventListener('click', () => {
      navUl.classList.toggle('open');
    });
  }
});
