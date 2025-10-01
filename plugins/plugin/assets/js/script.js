/**
 * Conifer Features Plugin - Main JavaScript
 */
jQuery(document).ready(function($) {
    
    // Contact Form Handling
    $('#conifer-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('.contact-submit-btn');
        var messageDiv = $('#contact-form-message');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.find('.btn-text').hide();
        submitBtn.find('.btn-loading').show();
        
        // Clear previous messages
        messageDiv.hide().removeClass('success error');
        
        // Submit form data
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    messageDiv.removeClass('error').addClass('success').html(response.data).show();
                    form[0].reset();
                } else {
                    messageDiv.removeClass('success').addClass('error').html(response.data).show();
                }
            },
            error: function() {
                messageDiv.removeClass('success').addClass('error').html('An error occurred. Please try again.').show();
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                submitBtn.find('.btn-text').show();
                submitBtn.find('.btn-loading').hide();
            }
        });
    });
    
    // Slider Functionality
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
        
        function showSlide(index) {
            slides.removeClass('active');
            dots.removeClass('active');
            slides.eq(index).addClass('active');
            dots.eq(index).addClass('active');
            currentSlide = index;
        }
        
        function nextSlide() {
            var next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }
        
        function prevSlide() {
            var prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }
        
        function startAutoplay() {
            if (autoplay && slides.length > 1) {
                autoplayInterval = setInterval(nextSlide, speed);
            }
        }
        
        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
            }
        }
        
        // Navigation buttons
        nextBtn.on('click', function() {
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
        
        prevBtn.on('click', function() {
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
        
        // Dots navigation
        dots.on('click', function() {
            var index = $(this).data('slide');
            stopAutoplay();
            showSlide(index);
            startAutoplay();
        });
        
        // Pause on hover
        slider.on('mouseenter', stopAutoplay);
        slider.on('mouseleave', startAutoplay);
        
        // Start autoplay
        startAutoplay();
    });
    
    // Gallery Lightbox
    $('.gallery-lightbox').on('click', function(e) {
        e.preventDefault();
        
        var href = $(this).attr('href');
        var lightbox = $('<div class="conifer-lightbox"><div class="lightbox-content"><img src="' + href + '"><button class="lightbox-close">&times;</button></div></div>');
        
        $('body').append(lightbox);
        $('body').addClass('lightbox-open');
        
        // Close lightbox
        lightbox.on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                lightbox.remove();
                $('body').removeClass('lightbox-open');
            }
        });
        
        // Keyboard navigation
        $(document).on('keydown.lightbox', function(e) {
            if (e.keyCode === 27) { // ESC key
                lightbox.remove();
                $('body').removeClass('lightbox-open');
                $(document).off('keydown.lightbox');
            }
        });
    });
    
    // Rating System
    $('.conifer-rating .rating-star').on('click', function() {
        var rating = $(this).data('rating');
        var postId = $(this).closest('.conifer-rating').data('post-id');
        var ratingContainer = $(this).closest('.conifer-rating');
        
        // Update visual state
        $(this).siblings().removeClass('active');
        $(this).addClass('active').prevAll().addClass('active');
        
        // Submit rating via AJAX
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_submit_rating',
                post_id: postId,
                rating: rating,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update average rating display
                    if (ratingContainer.find('.rating-average').length) {
                        ratingContainer.find('.rating-value').text(response.data.average_rating);
                        ratingContainer.find('.rating-count').text(response.data.rating_count + ' ratings');
                    }
                    
                    // Show success message
                    ratingContainer.find('.rating-message').html('<span class="success">' + response.data.message + '</span>');
                } else {
                    ratingContainer.find('.rating-message').html('<span class="error">' + response.data + '</span>');
                }
            },
            error: function() {
                ratingContainer.find('.rating-message').html('<span class="error">An error occurred. Please try again.</span>');
            }
        });
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Form validation
    $('input[required], textarea[required]').on('blur', function() {
        var field = $(this);
        var value = field.val().trim();
        
        if (value === '') {
            field.addClass('error');
        } else {
            field.removeClass('error');
        }
    });
    
    // Email validation
    $('input[type="email"]').on('blur', function() {
        var field = $(this);
        var email = field.val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            field.addClass('error');
        } else {
            field.removeClass('error');
        }
    });
});
