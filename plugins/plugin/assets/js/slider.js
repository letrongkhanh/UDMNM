/**
 * Slider JavaScript
 */
jQuery(document).ready(function($) {
    
    $('.conifer-slider').each(function() {
        var slider = $(this);
        var wrapper = slider.find('.slider-wrapper');
        var slides = slider.find('.slide');
        var prevBtn = slider.find('.slider-prev');
        var nextBtn = slider.find('.slider-next');
        var dots = slider.find('.dot');
        var currentSlide = 0;
        var autoplay = slider.data('autoplay') === 'true';
        var speed = parseInt(slider.data('speed')) || 3000;
        var autoplayInterval;
        var isAnimating = false;
        
        // Initialize slider
        function initSlider() {
            if (slides.length === 0) return;
            
            // Show first slide
            slides.eq(0).addClass('active');
            dots.eq(0).addClass('active');
            
            // Start autoplay if enabled
            if (autoplay && slides.length > 1) {
                startAutoplay();
            }
        }
        
        function showSlide(index, direction) {
            if (isAnimating || slides.length <= 1) return;
            
            isAnimating = true;
            
            // Remove active classes
            slides.removeClass('active');
            dots.removeClass('active');
            
            // Add active classes to new slide
            slides.eq(index).addClass('active');
            dots.eq(index).addClass('active');
            
            currentSlide = index;
            
            // Reset animation flag after transition
            setTimeout(function() {
                isAnimating = false;
            }, 600);
        }
        
        function nextSlide() {
            var next = (currentSlide + 1) % slides.length;
            showSlide(next, 'next');
        }
        
        function prevSlide() {
            var prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev, 'prev');
        }
        
        function startAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
            }
            
            if (autoplay && slides.length > 1) {
                autoplayInterval = setInterval(nextSlide, speed);
            }
        }
        
        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
        }
        
        // Navigation buttons
        nextBtn.on('click', function(e) {
            e.preventDefault();
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
        
        prevBtn.on('click', function(e) {
            e.preventDefault();
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
        
        // Dots navigation
        dots.on('click', function(e) {
            e.preventDefault();
            var index = $(this).data('slide');
            stopAutoplay();
            showSlide(index);
            startAutoplay();
        });
        
        // Pause on hover
        slider.on('mouseenter', function() {
            stopAutoplay();
        });
        
        slider.on('mouseleave', function() {
            startAutoplay();
        });
        
        // Touch/swipe support
        var startX = 0;
        var startY = 0;
        var endX = 0;
        var endY = 0;
        
        slider.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
            startY = e.originalEvent.touches[0].clientY;
        });
        
        slider.on('touchend', function(e) {
            endX = e.originalEvent.changedTouches[0].clientX;
            endY = e.originalEvent.changedTouches[0].clientY;
            
            var diffX = startX - endX;
            var diffY = startY - endY;
            
            // Only trigger if horizontal swipe is greater than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                stopAutoplay();
                
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                
                startAutoplay();
            }
        });
        
        // Keyboard navigation
        slider.on('keydown', function(e) {
            switch(e.which) {
                case 37: // Left arrow
                    e.preventDefault();
                    stopAutoplay();
                    prevSlide();
                    startAutoplay();
                    break;
                case 39: // Right arrow
                    e.preventDefault();
                    stopAutoplay();
                    nextSlide();
                    startAutoplay();
                    break;
            }
        });
        
        // Make slider focusable for keyboard navigation
        slider.attr('tabindex', '0');
        
        // Lazy loading for images
        slides.find('img').each(function() {
            var img = $(this);
            if (img.data('src')) {
                img.attr('src', img.data('src'));
            }
        });
        
        // Preload next and previous images
        function preloadImages() {
            var nextIndex = (currentSlide + 1) % slides.length;
            var prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            
            slides.eq(nextIndex).find('img').each(function() {
                var img = new Image();
                img.src = $(this).attr('src');
            });
            
            slides.eq(prevIndex).find('img').each(function() {
                var img = new Image();
                img.src = $(this).attr('src');
            });
        }
        
        // Initialize
        initSlider();
        preloadImages();
        
        // Preload images when slide changes
        slider.on('slideChanged', function() {
            preloadImages();
        });
        
        // Visibility API - pause when tab is not visible
        if (typeof document.hidden !== 'undefined') {
            $(document).on('visibilitychange', function() {
                if (document.hidden) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
            });
        }
        
        // Window resize handler
        $(window).on('resize', function() {
            // Recalculate slider dimensions if needed
            slider.trigger('sliderResize');
        });
    });
});
