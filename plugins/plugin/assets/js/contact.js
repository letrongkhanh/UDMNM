/**
 * Contact Form JavaScript
 */
jQuery(document).ready(function($) {
    
    // Contact form submission
    $('#conifer-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('.contact-submit-btn');
        var messageDiv = $('#contact-form-message');
        var formData = new FormData(this);
        
        // Validate form
        if (!validateForm(form)) {
            return false;
        }
        
        // Show loading state
        setLoadingState(submitBtn, true);
        
        // Clear previous messages
        hideMessage(messageDiv);
        
        // Submit form data
        $.ajax({
            url: conifer_ajax.ajax_url,
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showMessage(messageDiv, response.data, 'success');
                    form[0].reset();
                    resetFormValidation(form);
                } else {
                    showMessage(messageDiv, response.data, 'error');
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    errorMessage = xhr.responseJSON.data;
                }
                showMessage(messageDiv, errorMessage, 'error');
            },
            complete: function() {
                setLoadingState(submitBtn, false);
            }
        });
    });
    
    // Real-time form validation
    $('#conifer-contact-form input, #conifer-contact-form textarea').on('blur', function() {
        validateField($(this));
    });
    
    $('#conifer-contact-form input, #conifer-contact-form textarea').on('input', function() {
        var field = $(this);
        if (field.hasClass('error')) {
            validateField(field);
        }
    });
    
    // Email validation
    $('#conifer-contact-form input[type="email"]').on('blur', function() {
        var field = $(this);
        var email = field.val().trim();
        
        if (email && !isValidEmail(email)) {
            showFieldError(field, 'Please enter a valid email address');
        } else {
            clearFieldError(field);
        }
    });
    
    // Phone number formatting
    $('#conifer-contact-form input[type="tel"]').on('input', function() {
        var field = $(this);
        var value = field.val().replace(/\D/g, '');
        
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            } else {
                value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
            }
        }
        
        field.val(value);
    });
    
    // Character counter for message field
    $('#conifer-contact-form textarea').on('input', function() {
        var field = $(this);
        var maxLength = field.attr('maxlength');
        var currentLength = field.val().length;
        
        if (maxLength) {
            var counter = field.siblings('.char-counter');
            if (counter.length === 0) {
                counter = $('<div class="char-counter"></div>');
                field.after(counter);
            }
            
            counter.text(currentLength + '/' + maxLength);
            
            if (currentLength > maxLength * 0.9) {
                counter.addClass('warning');
            } else {
                counter.removeClass('warning');
            }
        }
    });
    
    // Form validation functions
    function validateForm(form) {
        var isValid = true;
        var requiredFields = form.find('[required]');
        
        requiredFields.each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });
        
        // Validate email
        var emailField = form.find('input[type="email"]');
        if (emailField.length && emailField.val()) {
            if (!isValidEmail(emailField.val())) {
                showFieldError(emailField, 'Please enter a valid email address');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    function validateField(field) {
        var value = field.val().trim();
        var isRequired = field.attr('required');
        var fieldType = field.attr('type');
        
        if (isRequired && !value) {
            showFieldError(field, 'This field is required');
            return false;
        }
        
        if (value) {
            if (fieldType === 'email' && !isValidEmail(value)) {
                showFieldError(field, 'Please enter a valid email address');
                return false;
            }
            
            if (fieldType === 'tel' && !isValidPhone(value)) {
                showFieldError(field, 'Please enter a valid phone number');
                return false;
            }
        }
        
        clearFieldError(field);
        return true;
    }
    
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhone(phone) {
        var phoneRegex = /^[\d\-\+\(\)\s]+$/;
        return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }
    
    function showFieldError(field, message) {
        field.addClass('error');
        var errorDiv = field.siblings('.field-error');
        if (errorDiv.length === 0) {
            errorDiv = $('<div class="field-error"></div>');
            field.after(errorDiv);
        }
        errorDiv.text(message).show();
    }
    
    function clearFieldError(field) {
        field.removeClass('error');
        field.siblings('.field-error').hide();
    }
    
    function resetFormValidation(form) {
        form.find('.field-error').hide();
        form.find('input, textarea').removeClass('error');
        form.find('.char-counter').remove();
    }
    
    function setLoadingState(button, isLoading) {
        if (isLoading) {
            button.prop('disabled', true);
            button.find('.btn-text').hide();
            button.find('.btn-loading').show();
        } else {
            button.prop('disabled', false);
            button.find('.btn-text').show();
            button.find('.btn-loading').hide();
        }
    }
    
    function showMessage(container, message, type) {
        container.removeClass('success error')
                 .addClass(type)
                 .html(message)
                 .slideDown();
    }
    
    function hideMessage(container) {
        container.slideUp().removeClass('success error');
    }
    
    // Auto-save form data to localStorage
    var formId = 'conifer-contact-form';
    
    function saveFormData() {
        var formData = {};
        $('#conifer-contact-form input, #conifer-contact-form textarea').each(function() {
            var field = $(this);
            if (field.attr('name') && field.val()) {
                formData[field.attr('name')] = field.val();
            }
        });
        localStorage.setItem(formId, JSON.stringify(formData));
    }
    
    function loadFormData() {
        var savedData = localStorage.getItem(formId);
        if (savedData) {
            try {
                var formData = JSON.parse(savedData);
                $.each(formData, function(name, value) {
                    $('#conifer-contact-form [name="' + name + '"]').val(value);
                });
            } catch (e) {
                console.log('Error loading saved form data');
            }
        }
    }
    
    function clearSavedData() {
        localStorage.removeItem(formId);
    }
    
    // Save form data on input
    $('#conifer-contact-form input, #conifer-contact-form textarea').on('input', function() {
        saveFormData();
    });
    
    // Load saved data on page load
    loadFormData();
    
    // Clear saved data on successful submission
    $('#conifer-contact-form').on('submit', function() {
        setTimeout(function() {
            if ($('#contact-form-message.success').is(':visible')) {
                clearSavedData();
            }
        }, 1000);
    });
    
    // Form analytics (if needed)
    function trackFormEvent(event, data) {
        if (typeof gtag !== 'undefined') {
            gtag('event', event, data);
        }
    }
    
    // Track form start
    $('#conifer-contact-form').on('focus', 'input, textarea', function() {
        trackFormEvent('form_start', {
            'form_name': 'contact_form'
        });
    });
    
    // Track form submission
    $('#conifer-contact-form').on('submit', function() {
        trackFormEvent('form_submit', {
            'form_name': 'contact_form'
        });
    });
});
