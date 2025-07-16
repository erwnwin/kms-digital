document.addEventListener('DOMContentLoaded', function() {
    // Back to Top Button
    const backToTopButton = document.querySelector('.back-to-top');

    const navbar = document.querySelector('.navbar');

    function handleScroll() {
        if (window.scrollY === 0) {
            navbar.classList.add('at-top');
            navbar.classList.remove('scrolled');
        } else {
            navbar.classList.remove('at-top');
            navbar.classList.add('scrolled');
        }
    }

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('load', handleScroll);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('active');
        } else {
            backToTopButton.classList.remove('active');
        }
    });
    
    backToTopButton.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Testimonial slider
    if (document.querySelector('.testimonial-slider')) {
        // You can initialize a slider here (like TinySlider, Slick, etc.)
        // For simplicity, we'll just use Bootstrap carousel in the HTML if needed
    }
    
    // Animate elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.service-card, .testimonial-item');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial state
    document.querySelectorAll('.service-card, .testimonial-item').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on load
});



// Tambahkan di script.js
document.addEventListener('DOMContentLoaded', function() {
    const circle = document.querySelector('.circle-decoration');
    const triangle = document.querySelector('.triangle-decoration');
    
    if (circle && triangle) {
        // Fungsi untuk menghasilkan posisi acak
        function randomMovement(element, duration) {
            const keyframes = [
                { transform: 'translate(0, 0) rotate(0deg)' },
                { transform: `translate(${Math.random() * 40 - 20}px, ${Math.random() * 30 - 15}px) rotate(${Math.random() * 10 - 5}deg)` },
                { transform: `translate(${Math.random() * 40 - 20}px, ${Math.random() * 30 - 15}px) rotate(${Math.random() * 10 - 5}deg)` },
                { transform: 'translate(0, 0) rotate(0deg)' }
            ];
            
            const options = {
                duration: duration,
                iterations: Infinity,
                direction: 'alternate',
                easing: 'ease-in-out'
            };
            
            element.animate(keyframes, options);
        }
        
        randomMovement(circle, 15000);
        randomMovement(triangle, 12000);
    }
});


