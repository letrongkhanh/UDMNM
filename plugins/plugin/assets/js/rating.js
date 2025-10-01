/**
 * Rating System JavaScript
 */
jQuery(document).ready(function($) {
    
    // Initialize rating systems
    $('.conifer-rating').each(function() {
        var rating = $(this);
        var ratingStars = rating.find('.rating-star');
        var postId = rating.data('post-id');
        
        // Star hover effects
        ratingStars.on('mouseenter', function() {
            var index = $(this).index();
            ratingStars.removeClass('hover');
            ratingStars.slice(0, index + 1).addClass('hover');
        });
        
        ratingStars.on('mouseleave', function() {
            ratingStars.removeClass('hover');
        });
        
        // Star click handler
        ratingStars.on('click', function() {
            var ratingValue = $(this).data('rating');
            submitRating(rating, postId, ratingValue);
        });
        
        // Keyboard navigation
        ratingStars.on('keydown', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                var ratingValue = $(this).data('rating');
                submitRating(rating, postId, ratingValue);
            }
        });
    });
    
    function submitRating(ratingContainer, postId, ratingValue) {
        var ratingStars = ratingContainer.find('.rating-star');
        var messageDiv = ratingContainer.find('.rating-message');
        
        // Update visual state
        ratingStars.removeClass('active hover');
        ratingStars.slice(0, ratingValue).addClass('active');
        
        // Show loading state
        showRatingMessage(messageDiv, 'Submitting rating...', 'info');
        
        // Submit rating via AJAX
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_submit_rating',
                post_id: postId,
                rating: ratingValue,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update average rating display
                    updateAverageRating(ratingContainer, response.data);
                    
                    // Show success message
                    showRatingMessage(messageDiv, response.data.message, 'success');
                    
                    // Track rating event
                    trackRatingEvent('rating_submitted', {
                        'post_id': postId,
                        'rating': ratingValue
                    });
                } else {
                    showRatingMessage(messageDiv, response.data, 'error');
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    errorMessage = xhr.responseJSON.data;
                }
                showRatingMessage(messageDiv, errorMessage, 'error');
            }
        });
    }
    
    function updateAverageRating(ratingContainer, data) {
        var averageDisplay = ratingContainer.find('.rating-average');
        var stars = averageDisplay.find('.star');
        var ratingValue = averageDisplay.find('.rating-value');
        var ratingCount = ratingContainer.find('.rating-count');
        
        if (averageDisplay.length) {
            // Update stars
            stars.removeClass('filled');
            for (var i = 0; i < Math.floor(data.average_rating); i++) {
                stars.eq(i).addClass('filled');
            }
            
            // Update rating value
            if (ratingValue.length) {
                ratingValue.text(data.average_rating);
            }
        }
        
        // Update rating count
        if (ratingCount.length) {
            var countText = data.rating_count === 1 ? '1 rating' : data.rating_count + ' ratings';
            ratingCount.text(countText);
        }
    }
    
    function showRatingMessage(container, message, type) {
        container.removeClass('success error info')
                 .addClass(type)
                 .html('<span class="' + type + '">' + message + '</span>')
                 .slideDown();
        
        // Auto-hide info messages
        if (type === 'info') {
            setTimeout(function() {
                container.slideUp();
            }, 2000);
        }
    }
    
    // Rating breakdown (if implemented)
    function initRatingBreakdown(ratingContainer) {
        var breakdown = ratingContainer.find('.rating-breakdown');
        if (breakdown.length === 0) return;
        
        var postId = ratingContainer.data('post-id');
        
        // Load rating breakdown via AJAX
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'conifer_get_rating_breakdown',
                post_id: postId,
                nonce: conifer_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateRatingBreakdown(breakdown, response.data);
                }
            }
        });
    }
    
    function updateRatingBreakdown(breakdown, data) {
        for (var i = 5; i >= 1; i--) {
            var item = breakdown.find('[data-rating="' + i + '"]');
            var fill = item.find('.rating-breakdown-fill');
            var count = item.find('.rating-breakdown-count');
            
            var percentage = data.total > 0 ? (data.breakdown[i] / data.total) * 100 : 0;
            
            fill.css('width', percentage + '%');
            count.text(data.breakdown[i] || 0);
        }
    }
    
    // Rating analytics
    function trackRatingEvent(event, data) {
        if (typeof gtag !== 'undefined') {
            gtag('event', event, data);
        }
    }
    
    // Initialize rating breakdowns
    $('.conifer-rating').each(function() {
        initRatingBreakdown($(this));
    });
    
    // Rating animations
    function animateRatingStars(ratingContainer, ratingValue) {
        var stars = ratingContainer.find('.rating-star');
        
        stars.each(function(index) {
            var star = $(this);
            if (index < ratingValue) {
                setTimeout(function() {
                    star.addClass('rating-animation');
                    setTimeout(function() {
                        star.removeClass('rating-animation');
                    }, 600);
                }, index * 100);
            }
        });
    }
    
    // Enhanced star hover effects
    $('.conifer-rating .rating-star').on('mouseenter', function() {
        var rating = $(this).closest('.conifer-rating');
        var ratingValue = $(this).data('rating');
        var stars = rating.find('.rating-star');
        
        stars.removeClass('hover');
        stars.slice(0, ratingValue).addClass('hover');
    });
    
    $('.conifer-rating .rating-star').on('mouseleave', function() {
        var rating = $(this).closest('.conifer-rating');
        rating.find('.rating-star').removeClass('hover');
    });
    
    // Rating tooltips
    function initRatingTooltips() {
        $('.conifer-rating .rating-star').each(function() {
            var star = $(this);
            var rating = star.data('rating');
            var tooltip = getRatingTooltip(rating);
            
            star.attr('title', tooltip);
        });
    }
    
    function getRatingTooltip(rating) {
        var tooltips = {
            1: 'Poor',
            2: 'Fair',
            3: 'Good',
            4: 'Very Good',
            5: 'Excellent'
        };
        
        return tooltips[rating] || '';
    }
    
    // Initialize tooltips
    initRatingTooltips();
    
    // Rating accessibility
    function enhanceRatingAccessibility() {
        $('.conifer-rating .rating-star').each(function() {
            var star = $(this);
            var rating = star.data('rating');
            
            // Add ARIA attributes
            star.attr({
                'role': 'button',
                'tabindex': '0',
                'aria-label': 'Rate ' + rating + ' out of 5 stars'
            });
        });
    }
    
    // Initialize accessibility features
    enhanceRatingAccessibility();
    
    // Rating persistence (save user's rating in localStorage)
    function saveUserRating(postId, rating) {
        var ratings = JSON.parse(localStorage.getItem('conifer_ratings') || '{}');
        ratings[postId] = rating;
        localStorage.setItem('conifer_ratings', JSON.stringify(ratings));
    }
    
    function loadUserRating(postId) {
        var ratings = JSON.parse(localStorage.getItem('conifer_ratings') || '{}');
        return ratings[postId] || 0;
    }
    
    // Load saved ratings on page load
    $('.conifer-rating').each(function() {
        var rating = $(this);
        var postId = rating.data('post-id');
        var savedRating = loadUserRating(postId);
        
        if (savedRating > 0) {
            var stars = rating.find('.rating-star');
            stars.removeClass('active');
            stars.slice(0, savedRating).addClass('active');
        }
    });
    
    // Save rating when submitted
    $('.conifer-rating').on('ratingSubmitted', function(e, postId, rating) {
        saveUserRating(postId, rating);
    });
    
    // Custom event for rating submission
    $(document).on('ratingSubmitted', function(e, postId, rating) {
        saveUserRating(postId, rating);
    });
});
