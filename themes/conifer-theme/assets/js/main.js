/**
 * Conifer Theme JavaScript
 * 
 * @package Conifer
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // DOM Elements
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const heroSlider = document.querySelector('.hero-slider');
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const newsletterForm = document.getElementById('newsletter-form');
    const contactForm = document.getElementById('contact-form');

    // Global Variables
    let currentSlide = 0;
    let slideInterval;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        initSlider();
        initMobileMenu();
        initNewsletter();
        initContactForm();
        initScrollAnimations();
        initSmoothScrolling();
        initProductTabs();
        initQuantitySelector();
        initAddToCart();
        initWishlist();
    });

    // Hero Slider
    function initSlider() {
        if (slides.length === 0) return;
        
        // Auto slide
        slideInterval = setInterval(nextSlide, 5000);
        
        // Event listeners
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });
        
        // Pause on hover
        if (heroSlider) {
            heroSlider.addEventListener('mouseenter', pauseSlider);
            heroSlider.addEventListener('mouseleave', resumeSlider);
        }
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlider();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentSlide);
        });
        
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }

    function pauseSlider() {
        clearInterval(slideInterval);
    }

    function resumeSlider() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Mobile Menu
    function initMobileMenu() {
        if (!hamburger || !navMenu) return;
        
        hamburger.addEventListener('click', toggleMobileMenu);
        
        // Close menu when clicking on a link
        navMenu.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                closeMobileMenu();
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                closeMobileMenu();
            }
        });
    }

    function toggleMobileMenu() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }

    function closeMobileMenu() {
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
        document.body.classList.remove('menu-open');
    }

    // Newsletter
    function initNewsletter() {
        if (!newsletterForm) return;
        
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value;
            
            if (validateEmail(email)) {
                subscribeNewsletter(email);
            } else {
                showNotification(conifer_ajax.invalid_email || 'Please enter a valid email address', 'error');
            }
        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function subscribeNewsletter(email) {
        const submitBtn = newsletterForm.querySelector('button');
        const originalText = submitBtn.textContent;
        
        submitBtn.innerHTML = '<div class="loading"></div>';
        submitBtn.disabled = true;
        
        // AJAX request
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_newsletter_subscribe',
                email: email,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.data.message || 'Thank you for subscribing!');
                    newsletterForm.reset();
                } else {
                    showNotification(response.data.message || 'Sorry, there was an error. Please try again.', 'error');
                }
            },
            error: function() {
                showNotification('Sorry, there was an error. Please try again.', 'error');
            },
            complete: function() {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Contact Form
    function initContactForm() {
        if (!contactForm) return;
        
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const submitBtn = contactForm.querySelector('.send-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            // AJAX request
            $.ajax({
                url: conifer_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'conifer_contact_form',
                    name: formData.get('name'),
                    email: formData.get('email'),
                    subject: formData.get('subject'),
                    message: formData.get('message'),
                    nonce: conifer_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message || 'Thank you for your message!');
                        contactForm.reset();
                    } else {
                        showNotification(response.data.message || 'Sorry, there was an error. Please try again.', 'error');
                    }
                },
                error: function() {
                    showNotification('Sorry, there was an error. Please try again.', 'error');
                },
                complete: function() {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            });
        });
    }

    // Product Tabs
    function initProductTabs() {
        const tabNav = document.querySelector('.tab-nav');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        if (!tabNav) return;
        
        tabNav.addEventListener('click', (e) => {
            e.preventDefault();
            
            const targetTab = e.target.getAttribute('href');
            if (!targetTab) return;
            
            // Remove active class from all tabs and panes
            tabNav.querySelectorAll('li').forEach(li => li.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked tab
            e.target.parentElement.classList.add('active');
            document.querySelector(targetTab).classList.add('active');
        });
    }

    // Quantity Selector
    function initQuantitySelector() {
        const quantityInputs = document.querySelectorAll('input[name="quantity"]');
        
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) this.value = 1;
                if (this.value > 10) this.value = 10;
            });
        });
    }

    // Add to Cart
    function initAddToCart() {
        const addToCartBtns = document.querySelectorAll('.add-to-cart, .add-to-cart-btn');
        
        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                addToCart(btn);
            });
        });
    }

    function addToCart(btn) {
        const productId = btn.getAttribute('data-product-id');
        const quantity = document.querySelector('input[name="quantity"]')?.value || 1;
        
        // AJAX request
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_add_to_cart',
                product_id: productId,
                quantity: quantity,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.data.message || 'Product added to cart!');
                    updateCartCount(response.data.cart_count || 0);
                } else {
                    showNotification(response.data.message || 'Sorry, there was an error.', 'error');
                }
            },
            error: function() {
                showNotification('Sorry, there was an error. Please try again.', 'error');
            }
        });
    }

    // Wishlist
    function initWishlist() {
        const wishlistBtns = document.querySelectorAll('.add-to-wishlist');
        
        wishlistBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                toggleWishlist(btn);
            });
        });
    }

    function toggleWishlist(btn) {
        const productId = btn.getAttribute('data-product-id');
        const icon = btn.querySelector('i');
        
        // AJAX request
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_toggle_wishlist',
                product_id: productId,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.added) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        btn.style.color = '#ff4757';
                        showNotification('Added to wishlist!');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        btn.style.color = '';
                        showNotification('Removed from wishlist!');
                    }
                }
            },
            error: function() {
                showNotification('Sorry, there was an error. Please try again.', 'error');
            }
        });
    }

    // Scroll Animations
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        
        // Observe elements
        const animatedElements = document.querySelectorAll('.feature-item, .product-card, .post-card');
        animatedElements.forEach(el => {
            el.classList.add('fade-in');
            observer.observe(el);
        });
    }

    // Smooth Scrolling
    function initSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const headerHeight = document.querySelector('.header').offsetHeight;
                    const targetPosition = targetElement.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Utility Functions
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    function updateCartCount(count) {
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            cartCount.textContent = count;
            cartCount.style.animation = 'pulse 0.3s ease';
        }
    }

    // Brand Logos Slider
    function initBrandLogosSlider() {
        const logosTrack = document.getElementById('logosTrack');
        const prevBtn = document.querySelector('.prev-logo');
        const nextBtn = document.querySelector('.next-logo');
        
        if (!logosTrack || !prevBtn || !nextBtn) return;
        
        let currentIndex = 0;
        const itemsPerView = 5;
        const totalItems = logosTrack.children.length;
        const maxIndex = Math.max(0, totalItems - itemsPerView);
        
        function updateSlider() {
            const itemWidth = 200;
            const gap = 40;
            const translateX = -currentIndex * (itemWidth + gap);
            logosTrack.style.transform = `translateX(${translateX}px)`;
            
            prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.3' : '1';
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
        }
        
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSlider();
            }
        });
        
        updateSlider();
    }

    // Initialize brand logos slider
    initBrandLogosSlider();

})(jQuery);
