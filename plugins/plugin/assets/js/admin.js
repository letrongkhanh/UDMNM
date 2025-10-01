/**
 * Conifer Features Plugin - Admin JavaScript
 */
jQuery(document).ready(function($) {
    
    // Media Uploader for Slider Images
    var mediaUploader;
    
    $('#add-slider-image').click(function(e) {
        e.preventDefault();
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Images',
            button: {
                text: 'Choose Images'
            },
            multiple: true
        });
        
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            $.each(attachments, function(index, attachment) {
                $('#slider-images-list').append(
                    '<div class="slider-image-item">' +
                    '<img src="' + attachment.url + '" style="max-width: 150px; height: auto;">' +
                    '<input type="hidden" name="slider_images[]" value="' + attachment.id + '">' +
                    '<button type="button" class="remove-slider-image">Remove</button>' +
                    '</div>'
                );
            });
        });
        
        mediaUploader.open();
    });
    
    // Media Uploader for Gallery Images
    $('#add-gallery-image').click(function(e) {
        e.preventDefault();
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Images',
            button: {
                text: 'Choose Images'
            },
            multiple: true
        });
        
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            $.each(attachments, function(index, attachment) {
                $('#gallery-images-list').append(
                    '<div class="gallery-image-item">' +
                    '<img src="' + attachment.url + '" style="max-width: 150px; height: auto;">' +
                    '<input type="hidden" name="gallery_images[]" value="' + attachment.id + '">' +
                    '<button type="button" class="remove-gallery-image">Remove</button>' +
                    '</div>'
                );
            });
        });
        
        mediaUploader.open();
    });
    
    // Remove image handlers
    $(document).on('click', '.remove-slider-image', function() {
        $(this).parent().remove();
    });
    
    $(document).on('click', '.remove-gallery-image', function() {
        $(this).parent().remove();
    });
    
    // Settings form validation
    $('.conifer_features_settings form').on('submit', function(e) {
        var email = $('input[name="conifer_features_options[contact_email]"]').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            $('input[name="conifer_features_options[contact_email]"]').focus();
            return false;
        }
    });
    
    // Admin notices
    $('.notice').on('click', '.notice-dismiss', function() {
        $(this).closest('.notice').fadeOut();
    });
    
    // Auto-dismiss notices after 5 seconds
    setTimeout(function() {
        $('.notice:not(.notice-error)').fadeOut();
    }, 5000);
    
    // Confirm delete actions
    $('a[href*="action=delete"]').on('click', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
    
    // Sortable image lists
    $('#slider-images-list, #gallery-images-list').sortable({
        placeholder: 'ui-state-highlight',
        update: function(event, ui) {
            // Update order if needed
        }
    });
    
    // Toggle settings sections
    $('.conifer-features-info h2').on('click', function() {
        $(this).next('.feature-grid').slideToggle();
    });
    
    // Color picker for custom colors (if needed)
    if ($.fn.wpColorPicker) {
        $('.color-picker').wpColorPicker();
    }
    
    // Date picker for date fields (if needed)
    if ($.fn.datepicker) {
        $('.date-picker').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    }
    
    // Form field dependencies
    $('input[name="conifer_features_options[enable_auto_reply]"]').on('change', function() {
        var emailField = $('input[name="conifer_features_options[contact_email]"]');
        if ($(this).is(':checked')) {
            emailField.prop('required', true);
        } else {
            emailField.prop('required', false);
        }
    });
    
    // Initialize tooltips
    $('[data-tooltip]').each(function() {
        var tooltip = $(this).data('tooltip');
        $(this).attr('title', tooltip);
    });
    
    // Responsive table handling
    function handleResponsiveTables() {
        if ($(window).width() < 768) {
            $('.wp-list-table').addClass('mobile-table');
        } else {
            $('.wp-list-table').removeClass('mobile-table');
        }
    }
    
    $(window).on('resize', handleResponsiveTables);
    handleResponsiveTables();
});
