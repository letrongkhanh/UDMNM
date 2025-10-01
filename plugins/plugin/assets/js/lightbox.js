/**
 * Lightbox JavaScript
 */
jQuery(document).ready(function($) {
    
    // Initialize lightbox
    $('.gallery-lightbox').on('click', function(e) {
        e.preventDefault();
        
        var href = $(this).attr('href');
        var title = $(this).find('img').attr('alt') || '';
        var gallery = $(this).closest('.conifer-gallery');
        
        openLightbox(href, title, gallery);
    });
    
    function openLightbox(src, title, gallery) {
        // Create lightbox HTML
        var lightbox = $('<div class="conifer-lightbox">' +
            '<div class="lightbox-content">' +
                '<img src="' + src + '" alt="' + title + '">' +
                '<button class="lightbox-close">&times;</button>' +
                '<button class="lightbox-prev">‹</button>' +
                '<button class="lightbox-next">›</button>' +
                '<div class="lightbox-title">' + title + '</div>' +
            '</div>' +
        '</div>');
        
        // Add to DOM
        $('body').append(lightbox);
        $('body').addClass('lightbox-open');
        
        // Initialize lightbox navigation
        initLightboxNavigation(lightbox, gallery);
        
        // Close handlers
        lightbox.on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                closeLightbox(lightbox);
            }
        });
        
        // Keyboard navigation
        $(document).on('keydown.lightbox', function(e) {
            handleLightboxKeyboard(e, lightbox, gallery);
        });
        
        // Touch/swipe support
        initLightboxTouch(lightbox, gallery);
        
        // Focus management
        lightbox.attr('tabindex', '-1');
        lightbox.focus();
    }
    
    function initLightboxNavigation(lightbox, gallery) {
        var images = gallery.find('.gallery-lightbox');
        var currentIndex = images.index(images.filter('[href="' + lightbox.find('img').attr('src') + '"]'));
        
        // Navigation handlers
        lightbox.find('.lightbox-prev').on('click', function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateLightboxImage(lightbox, images.eq(currentIndex));
        });
        
        lightbox.find('.lightbox-next').on('click', function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % images.length;
            updateLightboxImage(lightbox, images.eq(currentIndex));
        });
        
        // Store data for navigation
        lightbox.data('current-index', currentIndex);
        lightbox.data('images', images);
        
        // Show/hide navigation buttons
        updateNavigationButtons(lightbox, images.length);
    }
    
    function updateLightboxImage(lightbox, imageLink) {
        var img = imageLink.find('img');
        var src = imageLink.attr('href');
        var title = img.attr('alt') || '';
        
        // Show loading
        showLightboxLoading(lightbox);
        
        // Update image
        lightbox.find('img').on('load', function() {
            hideLightboxLoading(lightbox);
        }).attr('src', src).attr('alt', title);
        
        // Update title
        lightbox.find('.lightbox-title').text(title);
        
        // Update current index
        lightbox.data('current-index', imageLink.index());
    }
    
    function updateNavigationButtons(lightbox, totalImages) {
        var prevBtn = lightbox.find('.lightbox-prev');
        var nextBtn = lightbox.find('.lightbox-next');
        
        if (totalImages <= 1) {
            prevBtn.hide();
            nextBtn.hide();
        } else {
            prevBtn.show();
            nextBtn.show();
        }
    }
    
    function handleLightboxKeyboard(e, lightbox, gallery) {
        var currentIndex = lightbox.data('current-index');
        var images = lightbox.data('images');
        
        switch(e.which) {
            case 27: // ESC key
                closeLightbox(lightbox);
                break;
            case 37: // Left arrow
                e.preventDefault();
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateLightboxImage(lightbox, images.eq(currentIndex));
                lightbox.data('current-index', currentIndex);
                break;
            case 39: // Right arrow
                e.preventDefault();
                currentIndex = (currentIndex + 1) % images.length;
                updateLightboxImage(lightbox, images.eq(currentIndex));
                lightbox.data('current-index', currentIndex);
                break;
        }
    }
    
    function initLightboxTouch(lightbox, gallery) {
        var startX = 0;
        var startY = 0;
        var endX = 0;
        var endY = 0;
        var minSwipeDistance = 50;
        
        lightbox.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
            startY = e.originalEvent.touches[0].clientY;
        });
        
        lightbox.on('touchend', function(e) {
            endX = e.originalEvent.changedTouches[0].clientX;
            endY = e.originalEvent.changedTouches[0].clientY;
            
            var diffX = startX - endX;
            var diffY = startY - endY;
            
            // Only trigger if horizontal swipe is greater than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > minSwipeDistance) {
                var images = lightbox.data('images');
                var currentIndex = lightbox.data('current-index');
                
                if (diffX > 0) {
                    // Swipe left - next image
                    currentIndex = (currentIndex + 1) % images.length;
                } else {
                    // Swipe right - previous image
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                }
                
                updateLightboxImage(lightbox, images.eq(currentIndex));
                lightbox.data('current-index', currentIndex);
            }
        });
    }
    
    function showLightboxLoading(lightbox) {
        var loading = $('<div class="lightbox-loading"></div>');
        lightbox.find('.lightbox-content').append(loading);
    }
    
    function hideLightboxLoading(lightbox) {
        lightbox.find('.lightbox-loading').remove();
    }
    
    function closeLightbox(lightbox) {
        lightbox.fadeOut(300, function() {
            lightbox.remove();
            $('body').removeClass('lightbox-open');
            $(document).off('keydown.lightbox');
        });
    }
    
    // Preload adjacent images
    function preloadAdjacentImages(lightbox, gallery) {
        var images = lightbox.data('images');
        var currentIndex = lightbox.data('current-index');
        var totalImages = images.length;
        
        if (totalImages <= 1) return;
        
        // Preload next image
        var nextIndex = (currentIndex + 1) % totalImages;
        var nextImg = new Image();
        nextImg.src = images.eq(nextIndex).attr('href');
        
        // Preload previous image
        var prevIndex = (currentIndex - 1 + totalImages) % totalImages;
        var prevImg = new Image();
        prevImg.src = images.eq(prevIndex).attr('href');
    }
    
    // Initialize preloading when lightbox opens
    $(document).on('lightboxOpened', function(e, lightbox, gallery) {
        preloadAdjacentImages(lightbox, gallery);
    });
    
    // Lightbox analytics
    function trackLightboxEvent(event, data) {
        if (typeof gtag !== 'undefined') {
            gtag('event', event, data);
        }
    }
    
    // Track lightbox interactions
    $('.gallery-lightbox').on('click', function() {
        var gallery = $(this).closest('.conifer-gallery');
        trackLightboxEvent('lightbox_open', {
            'gallery_id': gallery.attr('id') || 'unknown'
        });
    });
    
    // Accessibility enhancements
    function enhanceLightboxAccessibility() {
        $('.gallery-lightbox').each(function() {
            var link = $(this);
            var img = link.find('img');
            
            // Add ARIA attributes
            link.attr({
                'role': 'button',
                'aria-label': 'Open image: ' + (img.attr('alt') || 'Gallery image')
            });
        });
    }
    
    // Initialize accessibility features
    enhanceLightboxAccessibility();
    
    // Fullscreen support
    function toggleFullscreen(lightbox) {
        if (!document.fullscreenElement) {
            lightbox[0].requestFullscreen().catch(function(err) {
                console.log('Error attempting to enable fullscreen:', err);
            });
        } else {
            document.exitFullscreen();
        }
    }
    
    // Add fullscreen button (optional)
    function addFullscreenButton(lightbox) {
        var fullscreenBtn = $('<button class="lightbox-fullscreen" title="Toggle fullscreen">⛶</button>');
        lightbox.find('.lightbox-content').append(fullscreenBtn);
        
        fullscreenBtn.on('click', function(e) {
            e.stopPropagation();
            toggleFullscreen(lightbox);
        });
    }
    
    // Zoom functionality (optional)
    function initLightboxZoom(lightbox) {
        var img = lightbox.find('img');
        var isZoomed = false;
        
        img.on('click', function(e) {
            e.stopPropagation();
            
            if (isZoomed) {
                img.css({
                    'transform': 'scale(1)',
                    'cursor': 'zoom-in'
                });
                isZoomed = false;
            } else {
                img.css({
                    'transform': 'scale(1.5)',
                    'cursor': 'zoom-out'
                });
                isZoomed = true;
            }
        });
    }
    
    // Initialize zoom on lightbox open
    $(document).on('lightboxOpened', function(e, lightbox, gallery) {
        initLightboxZoom(lightbox);
    });
});
