<?php
/**
 * Contact page template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Contact Page Header -->
    <section class="contact-header">
        <div class="container">
            <h1><?php _e('CONTACT US', 'conifer'); ?></h1>
            <nav class="breadcrumb">
                <span><?php _e('CONTACT US', 'conifer'); ?></span>
            </nav>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-main">
        <div class="container">
            <div class="contact-layout">
                <!-- Store Information -->
                <div class="store-info">
                    <h2><?php _e('Store Information', 'conifer'); ?></h2>
                    <div class="info-divider"></div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <p><?php echo get_theme_mod('conifer_address', 'Hue City, Vietnam'); ?></p>
                            <p><?php _e('France', 'conifer'); ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <p><?php _e('Call us:', 'conifer'); ?></p>
                            <p><?php echo get_theme_mod('conifer_phone', '+84 905 567 890'); ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-fax"></i>
                        </div>
                        <div class="info-content">
                            <p><?php _e('Fax:', 'conifer'); ?></p>
                            <p>123456</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <p><?php _e('Email us:', 'conifer'); ?></p>
                            <p><?php echo get_theme_mod('conifer_email', 'info@conifer.com'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form">
                    <form class="form" id="contact-form" method="post" action="">
                        <?php wp_nonce_field('contact_form', 'contact_nonce'); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder="<?php _e('Your Name', 'conifer'); ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="<?php _e('Your Email', 'conifer'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="<?php _e('Subject', 'conifer'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <textarea id="message" name="message" class="form-control textarea" placeholder="<?php _e('Message', 'conifer'); ?>" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="send-btn"><?php _e('Send Message', 'conifer'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Handle contact form submission
if (isset($_POST['contact_nonce']) && wp_verify_nonce($_POST['contact_nonce'], 'contact_form')) {
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Send email
    $to = get_theme_mod('conifer_email', 'info@conifer.com');
    $email_subject = 'Contact Form: ' . $subject;
    $email_message = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        echo '<script>alert("' . __('Thank you for your message. We will get back to you soon!', 'conifer') . '");</script>';
    } else {
        echo '<script>alert("' . __('Sorry, there was an error sending your message. Please try again.', 'conifer') . '");</script>';
    }
}

get_footer(); ?>
