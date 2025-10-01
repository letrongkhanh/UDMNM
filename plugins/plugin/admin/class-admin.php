<?php
/**
 * Class quản lý giao diện admin
 */
class Conifer_Features_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('Conifer Features', 'conifer-features'),
            __('Conifer Features', 'conifer-features'),
            'manage_options',
            'conifer-features',
            array($this, 'admin_page'),
            'dashicons-admin-tools',
            30
        );
        
        add_submenu_page(
            'conifer-features',
            __('Settings', 'conifer-features'),
            __('Settings', 'conifer-features'),
            'manage_options',
            'conifer-features',
            array($this, 'admin_page')
        );
        
        add_submenu_page(
            'conifer-features',
            __('Contact Submissions', 'conifer-features'),
            __('Contact Submissions', 'conifer-features'),
            'manage_options',
            'conifer-contact-submissions',
            array($this, 'contact_submissions_page')
        );
        
        add_submenu_page(
            'conifer-features',
            __('Ratings', 'conifer-features'),
            __('Ratings', 'conifer-features'),
            'manage_options',
            'conifer-ratings',
            array($this, 'ratings_page')
        );
    }
    
    public function admin_init() {
        register_setting('conifer_features_settings', 'conifer_features_options');
        
        add_settings_section(
            'conifer_features_section',
            __('General Settings', 'conifer-features'),
            array($this, 'settings_section_callback'),
            'conifer_features_settings'
        );
        
        add_settings_field(
            'contact_email',
            __('Contact Form Email', 'conifer-features'),
            array($this, 'contact_email_callback'),
            'conifer_features_settings',
            'conifer_features_section'
        );
        
        add_settings_field(
            'enable_auto_reply',
            __('Enable Auto Reply', 'conifer-features'),
            array($this, 'enable_auto_reply_callback'),
            'conifer_features_settings',
            'conifer_features_section'
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Conifer Features Settings', 'conifer-features'); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('conifer_features_settings');
                do_settings_sections('conifer_features_settings');
                submit_button();
                ?>
            </form>
            
            <div class="conifer-features-info">
                <h2><?php _e('Plugin Features', 'conifer-features'); ?></h2>
                <div class="feature-grid">
                    <div class="feature-item">
                        <h3><?php _e('Logo Management', 'conifer-features'); ?></h3>
                        <p><?php _e('Customize your site logo through WordPress Customizer.', 'conifer-features'); ?></p>
                        <a href="<?php echo admin_url('customize.php'); ?>" class="button"><?php _e('Go to Customizer', 'conifer-features'); ?></a>
                    </div>
                    
                    <div class="feature-item">
                        <h3><?php _e('Slider', 'conifer-features'); ?></h3>
                        <p><?php _e('Create and manage image sliders for your website.', 'conifer-features'); ?></p>
                        <a href="<?php echo admin_url('edit.php?post_type=conifer_slider'); ?>" class="button"><?php _e('Manage Sliders', 'conifer-features'); ?></a>
                    </div>
                    
                    <div class="feature-item">
                        <h3><?php _e('Contact Form', 'conifer-features'); ?></h3>
                        <p><?php _e('Add contact forms to any page using shortcodes.', 'conifer-features'); ?></p>
                        <p><code>[conifer_contact_form]</code></p>
                    </div>
                    
                    <div class="feature-item">
                        <h3><?php _e('Gallery', 'conifer-features'); ?></h3>
                        <p><?php _e('Create beautiful image galleries with lightbox support.', 'conifer-features'); ?></p>
                        <a href="<?php echo admin_url('edit.php?post_type=conifer_gallery'); ?>" class="button"><?php _e('Manage Galleries', 'conifer-features'); ?></a>
                    </div>
                    
                    <div class="feature-item">
                        <h3><?php _e('Rating System', 'conifer-features'); ?></h3>
                        <p><?php _e('Add star ratings to posts and pages.', 'conifer-features'); ?></p>
                        <p><code>[conifer_rating]</code></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function contact_submissions_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_contact_submissions';
        
        // Handle delete action
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $wpdb->delete($table_name, array('id' => $id), array('%d'));
            echo '<div class="notice notice-success"><p>' . __('Submission deleted successfully.', 'conifer-features') . '</p></div>';
        }
        
        // Get submissions
        $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
        ?>
        <div class="wrap">
            <h1><?php _e('Contact Form Submissions', 'conifer-features'); ?></h1>
            
            <?php if (empty($submissions)): ?>
                <p><?php _e('No submissions yet.', 'conifer-features'); ?></p>
            <?php else: ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e('Name', 'conifer-features'); ?></th>
                            <th><?php _e('Email', 'conifer-features'); ?></th>
                            <th><?php _e('Phone', 'conifer-features'); ?></th>
                            <th><?php _e('Subject', 'conifer-features'); ?></th>
                            <th><?php _e('Message', 'conifer-features'); ?></th>
                            <th><?php _e('Date', 'conifer-features'); ?></th>
                            <th><?php _e('Actions', 'conifer-features'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $submission): ?>
                            <tr>
                                <td><?php echo esc_html($submission->name); ?></td>
                                <td><?php echo esc_html($submission->email); ?></td>
                                <td><?php echo esc_html($submission->phone); ?></td>
                                <td><?php echo esc_html($submission->subject); ?></td>
                                <td><?php echo esc_html(wp_trim_words($submission->message, 10)); ?></td>
                                <td><?php echo esc_html($submission->submitted_at); ?></td>
                                <td>
                                    <a href="?page=conifer-contact-submissions&action=delete&id=<?php echo $submission->id; ?>" 
                                       onclick="return confirm('<?php _e('Are you sure you want to delete this submission?', 'conifer-features'); ?>')"
                                       class="button button-small"><?php _e('Delete', 'conifer-features'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    }
    
    public function ratings_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_ratings';
        
        // Get ratings with post titles
        $ratings = $wpdb->get_results("
            SELECT r.*, p.post_title 
            FROM $table_name r 
            LEFT JOIN {$wpdb->posts} p ON r.post_id = p.ID 
            ORDER BY r.created_at DESC
        ");
        ?>
        <div class="wrap">
            <h1><?php _e('Rating System', 'conifer-features'); ?></h1>
            
            <?php if (empty($ratings)): ?>
                <p><?php _e('No ratings yet.', 'conifer-features'); ?></p>
            <?php else: ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e('Post', 'conifer-features'); ?></th>
                            <th><?php _e('User', 'conifer-features'); ?></th>
                            <th><?php _e('Rating', 'conifer-features'); ?></th>
                            <th><?php _e('Date', 'conifer-features'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ratings as $rating): ?>
                            <tr>
                                <td><?php echo esc_html($rating->post_title); ?></td>
                                <td><?php echo esc_html(get_userdata($rating->user_id)->display_name); ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?php echo $i <= $rating->rating ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                    (<?php echo $rating->rating; ?>/5)
                                </td>
                                <td><?php echo esc_html($rating->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    }
    
    public function settings_section_callback() {
        echo '<p>' . __('Configure the general settings for Conifer Features plugin.', 'conifer-features') . '</p>';
    }
    
    public function contact_email_callback() {
        $options = get_option('conifer_features_options');
        $email = isset($options['contact_email']) ? $options['contact_email'] : get_option('admin_email');
        echo '<input type="email" name="conifer_features_options[contact_email]" value="' . esc_attr($email) . '" class="regular-text" />';
        echo '<p class="description">' . __('Email address to receive contact form submissions.', 'conifer-features') . '</p>';
    }
    
    public function enable_auto_reply_callback() {
        $options = get_option('conifer_features_options');
        $enabled = isset($options['enable_auto_reply']) ? $options['enable_auto_reply'] : 1;
        echo '<input type="checkbox" name="conifer_features_options[enable_auto_reply]" value="1" ' . checked($enabled, 1, false) . ' />';
        echo '<label>' . __('Send automatic reply to users who submit contact forms.', 'conifer-features') . '</label>';
    }
}
