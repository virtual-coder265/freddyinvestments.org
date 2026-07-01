/**
 * Freddy Investments - Modern Client Engine
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Navigation Bar Styling on Scroll
    const header = document.querySelector('header nav');
    const scrollThreshold = 20;

    const handleScroll = () => {
        if (window.scrollY > scrollThreshold) {
            header.classList.add('glass-nav', 'py-3');
            header.classList.remove('py-5', 'bg-transparent');
        } else {
            header.classList.remove('glass-nav', 'py-3');
            header.classList.add('py-5', 'bg-transparent');
        }
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Trigger initial execution

    // 2. Responsive Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
            
            mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
            
            // Toggle hamburger icon animation
            const svgIcons = mobileMenuBtn.querySelectorAll('svg');
            if (svgIcons.length >= 2) {
                svgIcons[0].classList.toggle('hidden'); // Hamburger
                svgIcons[1].classList.toggle('hidden'); // Close Cross
            }
        });
    }

    // 3. Scroll Triggered Viewport Animations (Intersection Observer)
    const animateOnScroll = () => {
        const revealElements = document.querySelectorAll('.reveal-fade-in, .reveal-fade-up');
        
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                root: null, // Viewport
                rootMargin: '0px 0px -80px 0px', // Trigger slightly before element is fully visible
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-active');
                        // Stop observing once animated
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            revealElements.forEach(element => {
                observer.observe(element);
            });
        } else {
            // Fallback for older browsers
            revealElements.forEach(element => {
                element.classList.add('reveal-active');
            });
        }
    };

    animateOnScroll();

    // 4. Hero Background Slider
    const heroSliders = document.querySelectorAll('[data-hero-slider]');
    const reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    heroSliders.forEach(slider => {
        const heroSection = slider.closest('[data-hero-slider-section]') || slider.parentElement;
        const slides = Array.from(slider.querySelectorAll('[data-hero-slide]'));
        const dots = heroSection ? Array.from(heroSection.querySelectorAll('[data-hero-slide-dot]')) : [];
        const slideInterval = Number(slider.getAttribute('data-hero-slider-interval')) || 6500;

        if (slides.length === 0) {
            return;
        }

        let currentIndex = slides.findIndex(slide => slide.classList.contains('is-active'));
        let autoplayId = null;

        if (currentIndex < 0) {
            currentIndex = 0;
        }

        const setActiveSlide = (nextIndex) => {
            const normalizedIndex = (nextIndex + slides.length) % slides.length;

            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('is-active', slideIndex === normalizedIndex);
            });

            dots.forEach((dot, dotIndex) => {
                const isActive = dotIndex === normalizedIndex;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            currentIndex = normalizedIndex;
        };

        const stopAutoplay = () => {
            if (autoplayId !== null) {
                window.clearInterval(autoplayId);
                autoplayId = null;
            }
        };

        const startAutoplay = () => {
            if (slides.length < 2) {
                return;
            }

            stopAutoplay();
            autoplayId = window.setInterval(() => {
                setActiveSlide(currentIndex + 1);
            }, slideInterval);
        };

        dots.forEach((dot, dotIndex) => {
            dot.addEventListener('click', () => {
                setActiveSlide(dotIndex);
                startAutoplay();
            });
        });

        if (heroSection) {
            heroSection.addEventListener('mouseenter', stopAutoplay);
            heroSection.addEventListener('mouseleave', startAutoplay);
            heroSection.addEventListener('focusin', stopAutoplay);
            heroSection.addEventListener('focusout', (event) => {
                if (!heroSection.contains(event.relatedTarget)) {
                    startAutoplay();
                }
            });
        }

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });

        setActiveSlide(currentIndex);
        slider.classList.toggle('hero-slider-reduced-motion', reduceMotionQuery.matches);

        if (typeof reduceMotionQuery.addEventListener === 'function') {
            reduceMotionQuery.addEventListener('change', (event) => {
                slider.classList.toggle('hero-slider-reduced-motion', event.matches);
            });
        } else if (typeof reduceMotionQuery.addListener === 'function') {
            reduceMotionQuery.addListener((event) => {
                slider.classList.toggle('hero-slider-reduced-motion', event.matches);
            });
        }

        startAutoplay();
    });

    // 5. Portfolio Filter Engine
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    if (filterButtons.length > 0 && portfolioItems.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and add to clicked
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-emerald-500', 'text-slate-950'));
                filterButtons.forEach(btn => btn.classList.add('bg-slate-900', 'text-slate-300'));
                
                button.classList.add('active', 'bg-emerald-500', 'text-slate-950');
                button.classList.remove('bg-slate-900', 'text-slate-300');

                const filterValue = button.getAttribute('data-filter');

                portfolioItems.forEach(item => {
                    // Smooth transition layout matching
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.classList.remove('hidden');
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            item.classList.add('hidden');
                        }, 300);
                    }
                });
            });
        });
    }

    // 6. Secure Contact Form Client-side Pre-Validation
    const contactForm = document.getElementById('secure-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            let hasErrors = false;
            
            // Fetch inputs
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const serviceInput = document.getElementById('service');
            const messageInput = document.getElementById('message');

            // Reset custom inline errors
            document.querySelectorAll('.form-error-msg').forEach(el => el.textContent = '');

            // Validate Name
            if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
                showError(nameInput, 'Full name is required (min 2 chars).');
                hasErrors = true;
            }

            // Validate Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailInput.value.trim() || !emailRegex.test(emailInput.value.trim())) {
                showError(emailInput, 'Please enter a valid email address.');
                hasErrors = true;
            }

            // Validate Phone (optional but format checked if supplied)
            if (phoneInput.value.trim()) {
                const phoneRegex = /^[+0-9\-\(\)\s]{7,25}$/;
                if (!phoneRegex.test(phoneInput.value.trim())) {
                    showError(phoneInput, 'Please enter a valid phone number (digits, space, brackets, and hyphens).');
                    hasErrors = true;
                }
            }

            // Validate Service Interest
            if (!serviceInput.value) {
                showError(serviceInput, 'Please select a service category.');
                hasErrors = true;
            }

            // Validate Message
            if (!messageInput.value.trim() || messageInput.value.trim().length < 10) {
                showError(messageInput, 'Message must be at least 10 characters.');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault(); // Stop submission
            } else {
                // Show floating submitting indicator
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-slate-950 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Submitting securely...
                    `;
                }
            }
        });
    }

    // Helper to display input validation errors dynamically
    function showError(inputElement, errorMessage) {
        const errorContainer = inputElement.closest('div').querySelector('.form-error-msg');
        if (errorContainer) {
            errorContainer.textContent = errorMessage;
        }
        inputElement.focus();
    }
});
