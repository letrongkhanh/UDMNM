/**
 * Gallery JavaScript
 */
jQuery(document).ready(function($) {
    
    // Initialize galleries
    $('.conifer-gallery').each(function() {
        var gallery = $(this);
        var lightbox = gallery.data('lightbox') === 'true';
        
        if (lightbox) {
            initLightbox(gallery);
        }
        
        initGalleryFilters(gallery);
        initLazyLoading(gallery);
    });
    
    // Lightbox functionality
    function initLightbox(gallery) {
        gallery.find('.gallery-lightbox').on('click', function(e) {
            e.preventDefault();
            
            var href = $(this).attr('href');
            var title = $(this).find('img').attr('alt') || '';
            var lightbox = createLightbox(href, title);
            
            $('body').append(lightbox);
            $('body').addClass('lightbox-open');
            
            // Initialize lightbox navigation
            initLightboxNavigation(lightbox, gallery);
            
            // Close lightbox handlers
            lightbox.on('click', function(e) {
                if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                    closeLightbox(lightbox);
                }
            });
            
            // Keyboard navigation
            $(document).on('keydown.lightbox', function(e) {
                handleLightboxKeyboard(e, lightbox, gallery);
            });
        });
    }
    
    function createLightbox(src, title) {
        var lightbox = $('<div class="conifer-lightbox">' +
            '<div class="lightbox-content">' +
                '<img src="' + src + '" alt="' + title + '">' +
                '<button class="lightbox-close">&times;</button>' +
                '<div class="lightbox-title">' + title + '</div>' +
            '</div>' +
        '</div>');
        
        return lightbox;
    }
    
    function initLightboxNavigation(lightbox, gallery) {
        var images = gallery.find('.gallery-lightbox');
        var currentIndex = images.index(images.filter('[href="' + lightbox.find('img').attr('src') + '"]'));
        
        // Add navigation arrows
        var prevBtn = $('<button class="lightbox-prev">‹</button>');
        var nextBtn = $('<button class="lightbox-next">›</button>');
        
        lightbox.find('.lightbox-content').prepend(prevBtn).append(nextBtn);
        
        // Navigation handlers
        prevBtn.on('click', function() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateLightboxImage(lightbox, images.eq(currentIndex));
        });
        
        nextBtn.on('click', function() {
            currentIndex = (currentIndex + 1) % images.length;
            updateLightboxImage(lightbox, images.eq(currentIndex));
        });
        
        // Store current index for keyboard navigation
        lightbox.data('current-index', currentIndex);
        lightbox.data('images', images);
    }
    
    function updateLightboxImage(lightbox, imageLink) {
        var img = imageLink.find('img');
        var src = imageLink.attr('href');
        var title = img.attr('alt') || '';
        
        lightbox.find('img').attr('src', src).attr('alt', title);
        lightbox.find('.lightbox-title').text(title);
        
        // Update current index
        lightbox.data('current-index', imageLink.index());
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
    
    function closeLightbox(lightbox) {
        lightbox.fadeOut(300, function() {
            lightbox.remove();
            $('body').removeClass('lightbox-open');
            $(document).off('keydown.lightbox');
        });
    }
    
    // Gallery filters
    function initGalleryFilters(gallery) {
        var filterContainer = gallery.find('.gallery-filters');
        if (filterContainer.length === 0) return;
        
        var filterBtns = filterContainer.find('.gallery-filter-btn');
        var galleryItems = gallery.find('.gallery-item');
        
        filterBtns.on('click', function() {
            var filter = $(this).data('filter');
            
            // Update active button
            filterBtns.removeClass('active');
            $(this).addClass('active');
            
            // Filter items
            if (filter === 'all') {
                galleryItems.show().addClass('filtered-in');
            } else {
                galleryItems.hide().removeClass('filtered-in');
                galleryItems.filter('[data-category="' + filter + '"]').show().addClass('filtered-in');
            }
            
            // Animate filtered items
            galleryItems.filter('.filtered-in').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });
        });
    }
    
    // Lazy loading
    function initLazyLoading(gallery) {
        var images = gallery.find('img[data-src]');
        
        if (images.length === 0) return;
        
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = $(entry.target);
                    img.attr('src', img.data('src')).removeAttr('data-src');
                    img.addClass('loaded');
                    observer.unobserve(entry.target);
                }
            });
        });
        
        images.each(function() {
            imageObserver.observe(this);
        });
    }
    
    // Masonry layout (if implemented)
    function initMasonry(gallery) {
        if (gallery.hasClass('masonry')) {
            var grid = gallery.find('.gallery-grid');
            
            // Wait for images to load
            grid.find('img').on('load', function() {
                updateMasonryLayout(grid);
            });
            
            // Update on window resize
            $(window).on('resize', function() {
                updateMasonryLayout(grid);
            });
        }
    }
    
    function updateMasonryLayout(grid) {
        // Simple masonry implementation
        var items = grid.find('.gallery-item');
        var containerWidth = grid.width();
        var columnCount = Math.floor(containerWidth / 250); // 250px minimum item width
        var columnHeights = new Array(columnCount).fill(0);
        
        items.each(function() {
            var item = $(this);
            var shortestColumn = columnHeights.indexOf(Math.min(...columnHeights));
            
            item.css({
                'position': 'absolute',
                'top': columnHeights[shortestColumn] + 'px',
                'left': (shortestColumn * (containerWidth / columnCount)) + 'px',
                'width': (containerWidth / columnCount - 20) + 'px'
            });
            
            columnHeights[shortestColumn] += item.outerHeight() + 20;
        });
        
        grid.css('height', Math.max(...columnHeights) + 'px');
    }
    
    // Gallery search (if implemented)
    function initGallerySearch(gallery) {
        var searchInput = gallery.find('.gallery-search');
        if (searchInput.length === 0) return;
        
        var galleryItems = gallery.find('.gallery-item');
        
        searchInput.on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            galleryItems.each(function() {
                var item = $(this);
                var title = item.find('img').attr('alt') || '';
                var caption = item.find('.gallery-caption').text() || '';
                
                if (title.toLowerCase().includes(searchTerm) || 
                    caption.toLowerCase().includes(searchTerm)) {
                    item.show();
                } else {
                    item.hide();
                }
            });
        });
    }
    
    // Gallery analytics
    function trackGalleryEvent(event, data) {
        if (typeof gtag !== 'undefined') {
            gtag('event', event, data);
        }
    }
    
    // Track gallery interactions
    $('.conifer-gallery').on('click', '.gallery-lightbox', function() {
        var gallery = $(this).closest('.conifer-gallery');
        trackGalleryEvent('gallery_lightbox_open', {
            'gallery_id': gallery.attr('id') || 'unknown'
        });
    });
    
    // Initialize all gallery features
    $('.conifer-gallery').each(function() {
        var gallery = $(this);
        initMasonry(gallery);
        initGallerySearch(gallery);
    });
    
    // Responsive gallery handling
    function handleResponsiveGallery() {
        $('.conifer-gallery').each(function() {
            var gallery = $(this);
            var grid = gallery.find('.gallery-grid');
            
            if (grid.length) {
                var columns = gallery.data('columns') || 3;
                var windowWidth = $(window).width();
                
                if (windowWidth < 768) {
                    grid.css('grid-template-columns', 'repeat(2, 1fr)');
                } else if (windowWidth < 480) {
                    grid.css('grid-template-columns', '1fr');
                } else {
                    grid.css('grid-template-columns', 'repeat(' + columns + ', 1fr)');
                }
            }
        });
    }
    
    $(window).on('resize', handleResponsiveGallery);
    handleResponsiveGallery();
});
