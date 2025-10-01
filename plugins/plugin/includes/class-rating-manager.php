<?php
/**
 * Class quản lý rating
 */
class Rating_Manager {
    
    public function __construct() {
        add_action('wp_ajax_conifer_submit_rating', array($this, 'handle_rating_submission'));
        add_action('wp_ajax_nopriv_conifer_submit_rating', array($this, 'handle_rating_submission'));
        add_shortcode('conifer_rating', array($this, 'rating_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_rating_scripts'));
        add_action('wp_footer', array($this, 'add_rating_scripts'));
    }
    
    public function rating_shortcode($atts) {
        $atts = shortcode_atts(array(
            'post_id' => get_the_ID(),
            'show_average' => 'true',
            'show_count' => 'true',
            'allow_rating' => 'true',
            'class' => '',
        ), $atts);
        
        $post_id = intval($atts['post_id']);
        $show_average = $atts['show_average'] === 'true';
        $show_count = $atts['show_count'] === 'true';
        $allow_rating = $atts['allow_rating'] === 'true';
        
        $average_rating = $this->get_average_rating($post_id);
        $rating_count = $this->get_rating_count($post_id);
        $user_rating = $this->get_user_rating($post_id);
        
        ob_start();
        ?>
        <div class="conifer-rating <?php echo esc_attr($atts['class']); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
            <?php if ($show_average): ?>
                <div class="rating-average">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo $i <= $average_rating ? 'filled' : ''; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-value"><?php echo number_format($average_rating, 1); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($show_count): ?>
                <div class="rating-count">
                    <?php printf(_n('%d rating', '%d ratings', $rating_count, 'conifer-features'), $rating_count); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($allow_rating && is_user_logged_in()): ?>
                <div class="rating-form">
                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="rating-star <?php echo $i <= $user_rating ? 'active' : ''; ?>" 
                                  data-rating="<?php echo $i; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <div class="rating-message"></div>
                </div>
            <?php elseif ($allow_rating && !is_user_logged_in()): ?>
                <div class="rating-login-required">
                    <p><?php _e('Please log in to rate this item.', 'conifer-features'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function handle_rating_submission() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'conifer_features_nonce')) {
            wp_die(__('Security check failed', 'conifer-features'));
        }
        
        $post_id = intval($_POST['post_id']);
        $rating = intval($_POST['rating']);
        $user_id = get_current_user_id();
        
        // Validate rating
        if ($rating < 1 || $rating > 5) {
            wp_send_json_error(__('Invalid rating value', 'conifer-features'));
        }
        
        if (!$user_id) {
            wp_send_json_error(__('You must be logged in to rate', 'conifer-features'));
        }
        
        if (!$post_id || !get_post($post_id)) {
            wp_send_json_error(__('Invalid post', 'conifer-features'));
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_ratings';
        
        // Check if user already rated this post
        $existing_rating = $wpdb->get_var($wpdb->prepare(
            "SELECT rating FROM $table_name WHERE post_id = %d AND user_id = %d",
            $post_id,
            $user_id
        ));
        
        if ($existing_rating) {
            // Update existing rating
            $result = $wpdb->update(
                $table_name,
                array('rating' => $rating),
                array('post_id' => $post_id, 'user_id' => $user_id),
                array('%d'),
                array('%d', '%d')
            );
        } else {
            // Insert new rating
            $result = $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'rating' => $rating
                ),
                array('%d', '%d', '%d')
            );
        }
        
        if ($result !== false) {
            $average_rating = $this->get_average_rating($post_id);
            $rating_count = $this->get_rating_count($post_id);
            
            wp_send_json_success(array(
                'message' => __('Thank you for your rating!', 'conifer-features'),
                'average_rating' => $average_rating,
                'rating_count' => $rating_count
            ));
        } else {
            wp_send_json_error(__('Failed to save rating', 'conifer-features'));
        }
    }
    
    public function get_average_rating($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_ratings';
        
        $average = $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(rating) FROM $table_name WHERE post_id = %d",
            $post_id
        ));
        
        return $average ? round($average, 1) : 0;
    }
    
    public function get_rating_count($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_ratings';
        
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE post_id = %d",
            $post_id
        ));
    }
    
    public function get_user_rating($post_id) {
        if (!is_user_logged_in()) {
            return 0;
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'conifer_ratings';
        $user_id = get_current_user_id();
        
        return $wpdb->get_var($wpdb->prepare(
            "SELECT rating FROM $table_name WHERE post_id = %d AND user_id = %d",
            $post_id,
            $user_id
        )) ?: 0;
    }
    
    public function enqueue_rating_scripts() {
        wp_enqueue_style('conifer-rating-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/rating.css', array(), CONIFER_FEATURES_VERSION);
        wp_enqueue_script('conifer-rating-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/rating.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
    }
    
    public function add_rating_scripts() {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
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
        });
        </script>
        <?php
    }
}
