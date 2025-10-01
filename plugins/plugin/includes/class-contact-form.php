<?php
/**
 * Class quản lý form liên hệ
 */
class Contact_Form {
    
    public function __construct() {
        add_shortcode('conifer_contact_form', array($this, 'contact_form_shortcode'));
        add_action('wp_ajax_conifer_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_ajax_nopriv_conifer_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_contact_scripts'));
    }
    
    public function contact_form_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Contact Us', 'conifer-features'),
            'class' => '',
            'show_phone' => 'true',
            'show_subject' => 'true',
            'redirect_url' => '',
        ), $atts);
        
        ob_start();
        ?>
        <div class="conifer-contact-form <?php echo esc_attr($atts['class']); ?>">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <form id="conifer-contact-form" method="post">
                <?php wp_nonce_field('conifer_contact_form', 'conifer_contact_nonce'); ?>
                <input type="hidden" name="action" value="conifer_contact_form">
                <input type="hidden" name="redirect_url" value="<?php echo esc_url($atts['redirect_url']); ?>">
                
                <div class="form-group">
                    <label for="contact_name"><?php _e('Name', 'conifer-features'); ?> <span class="required">*</span></label>
                    <input type="text" id="contact_name" name="contact_name" required>
                </div>
                
                <div class="form-group">
                    <label for="contact_email"><?php _e('Email', 'conifer-features'); ?> <span class="required">*</span></label>
                    <input type="email" id="contact_email" name="contact_email" required>
                </div>
                
                <?php if ($atts['show_phone'] === 'true'): ?>
                <div class="form-group">
                    <label for="contact_phone"><?php _e('Phone', 'conifer-features'); ?></label>
                    <input type="tel" id="contact_phone" name="contact_phone">
                </div>
                <?php endif; ?>
                
                <?php if ($atts['show_subject'] === 'true'): ?>
                <div class="form-group">
                    <label for="contact_subject"><?php _e('Subject', 'conifer-features'); ?> <span class="required">*</span></label>
                    <input type="text" id="contact_subject" name="contact_subject" required>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="contact_message"><?php _e('Message', 'conifer-features'); ?> <span class="required">*</span></label>
                    <textarea id="contact_message" name="contact_message" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="contact-submit-btn">
                        <span class="btn-text"><?php _e('Send Message', 'conifer-features'); ?></span>
                        <span class="btn-loading" style="display: none;"><?php _e('Sending...', 'conifer-features'); ?></span>
                    </button>
                </div>
            </form>
            
            <div id="contact-form-message" style="display: none;"></div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function handle_contact_form() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['conifer_contact_nonce'], 'conifer_contact_form')) {
            wp_die(__('Security check failed', 'conifer-features'));
        }
        
        // Sanitize and validate data
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $phone = sanitize_text_field($_POST['contact_phone']);
        $subject = sanitize_text_field($_POST['contact_subject']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        $redirect_url = esc_url_raw($_POST['redirect_url']);
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(__('Please fill in all required fields', 'conifer-features'));
        }
        
        if (!is_email($email)) {
            wp_send_json_error(__('Please enter a valid email address', 'conifer-features'));
        }
        
        // Get admin email
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        
        // Prepare email content
        $email_subject = sprintf(__('[%s] New Contact Form Submission', 'conifer-features'), $site_name);
        if (!empty($subject)) {
            $email_subject = $subject;
        }
        
        $email_message = sprintf(__('You have received a new contact form submission from %s', 'conifer-features'), $site_name) . "\n\n";
        $email_message .= __('Name:', 'conifer-features') . ' ' . $name . "\n";
        $email_message .= __('Email:', 'conifer-features') . ' ' . $email . "\n";
        if (!empty($phone)) {
            $email_message .= __('Phone:', 'conifer-features') . ' ' . $phone . "\n";
        }
        $email_message .= __('Message:', 'conifer-features') . "\n" . $message . "\n\n";
        $email_message .= __('Sent from:', 'conifer-features') . ' ' . home_url();
        
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>'
        );
        
        // Send email
        $mail_sent = wp_mail($admin_email, $email_subject, $email_message, $headers);
        
        if ($mail_sent) {
            // Save to database (optional)
            $this->save_contact_submission($name, $email, $phone, $subject, $message);
            
            // Send auto-reply to user
            $this->send_auto_reply($name, $email, $site_name);
            
            wp_send_json_success(__('Thank you for your message. We will get back to you soon!', 'conifer-features'));
        } else {
            wp_send_json_error(__('Sorry, there was an error sending your message. Please try again later.', 'conifer-features'));
        }
    }
    
    private function save_contact_submission($name, $email, $phone, $subject, $message) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'conifer_contact_submissions';
        
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message,
                'submitted_at' => current_time('mysql'),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
    }
    
    private function send_auto_reply($name, $email, $site_name) {
        $auto_reply_subject = sprintf(__('Thank you for contacting %s', 'conifer-features'), $site_name);
        $auto_reply_message = sprintf(__('Dear %s,', 'conifer-features'), $name) . "\n\n";
        $auto_reply_message .= __('Thank you for your message. We have received your inquiry and will get back to you as soon as possible.', 'conifer-features') . "\n\n";
        $auto_reply_message .= __('Best regards,', 'conifer-features') . "\n";
        $auto_reply_message .= $site_name;
        
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . get_option('admin_email') . '>'
        );
        
        wp_mail($email, $auto_reply_subject, $auto_reply_message, $headers);
    }
    
    public function enqueue_contact_scripts() {
        wp_enqueue_style('conifer-contact-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/contact.css', array(), CONIFER_FEATURES_VERSION);
        wp_enqueue_script('conifer-contact-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/contact.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
    }
}
