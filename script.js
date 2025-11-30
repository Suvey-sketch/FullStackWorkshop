document.addEventListener('DOMContentLoaded', function () {
    
    // Mobile Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('open');
            const isExpanded = navLinks.classList.contains('open');
            menuToggle.setAttribute('aria-expanded', isExpanded);
            menuToggle.innerHTML = isExpanded ? '✕' : '☰';
        });
    }
    
    // Close menu when a link is clicked (mobile UX)
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (navLinks.classList.contains('open')) {
                navLinks.classList.toggle('open');
                menuToggle.innerHTML = '☰';
            }
        });
    });

    // Smooth scrolling for nav links
    const navItems = document.querySelectorAll('nav ul li a');
    navItems.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Scroll Progress Indicator
    const scrollProgress = document.getElementById('scroll-progress');
    
    function updateScrollProgress() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollPercentage = (scrollTop / scrollHeight) * 100;
        scrollProgress.style.width = scrollPercentage + '%';
    }
    
    window.addEventListener('scroll', updateScrollProgress);

    // Highlight nav links on scroll
    const sections = document.querySelectorAll('main section');
    
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

    // Form Submission Handling with Validation
    const form = document.getElementById('contact-form');
    const messageDiv = document.getElementById('form-message');
    
    if (form && messageDiv) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('message');
            
            // Validation
            if (!nameInput.value.trim()) {
                messageDiv.textContent = 'Please enter your name.';
                messageDiv.style.color = 'red';
                messageDiv.style.backgroundColor = '#ffe6e6';
                messageDiv.style.padding = '10px';
                nameInput.focus();
                return;
            }
            
            if (!emailInput.value.trim()) {
                messageDiv.textContent = 'Please enter your email.';
                messageDiv.style.color = 'red';
                messageDiv.style.backgroundColor = '#ffe6e6';
                messageDiv.style.padding = '10px';
                emailInput.focus();
                return;
            }
            
            // Email format validation
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
            if (!emailPattern.test(emailInput.value.trim())) {
                messageDiv.textContent = 'Please enter a valid email address.';
                messageDiv.style.color = 'red';
                messageDiv.style.backgroundColor = '#ffe6e6';
                messageDiv.style.padding = '10px';
                emailInput.focus();
                return;
            }
            
            if (!messageInput.value.trim()) {
                messageDiv.textContent = 'Please enter your message.';
                messageDiv.style.color = 'red';
                messageDiv.style.backgroundColor = '#ffe6e6';
                messageDiv.style.padding = '10px';
                messageInput.focus();
                return;
            }
            
            // Success message
            messageDiv.textContent = 'Thank you for your message, ' + nameInput.value + '! I will be in touch shortly.';
            messageDiv.style.color = 'green';
            messageDiv.style.backgroundColor = '#e6ffe6';
            messageDiv.style.padding = '10px';
            
            // Clear the form
            form.reset();
        });
    }
});