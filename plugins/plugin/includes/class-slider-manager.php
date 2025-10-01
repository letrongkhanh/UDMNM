<?php
/**
 * Class quản lý slider
 */
class Slider_Manager {
    
    public function __construct() {
        add_action('init', array($this, 'create_slider_post_type'));
        add_action('add_meta_boxes', array($this, 'add_slider_meta_boxes'));
        add_action('save_post', array($this, 'save_slider_meta'));
        add_shortcode('conifer_slider', array($this, 'slider_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_slider_scripts'));
    }
    
    public function create_slider_post_type() {
        register_post_type('conifer_slider', array(
            'labels' => array(
                'name' => __('Sliders', 'conifer-features'),
                'singular_name' => __('Slider', 'conifer-features'),
                'add_new' => __('Add New Slider', 'conifer-features'),
                'add_new_item' => __('Add New Slider', 'conifer-features'),
                'edit_item' => __('Edit Slider', 'conifer-features'),
                'new_item' => __('New Slider', 'conifer-features'),
                'view_item' => __('View Slider', 'conifer-features'),
                'search_items' => __('Search Sliders', 'conifer-features'),
                'not_found' => __('No sliders found', 'conifer-features'),
                'not_found_in_trash' => __('No sliders found in Trash', 'conifer-features'),
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-images-alt2',
        ));
    }
    
    public function add_slider_meta_boxes() {
        add_meta_box(
            'slider_images',
            __('Slider Images', 'conifer-features'),
            array($this, 'slider_images_callback'),
            'conifer_slider',
            'normal',
            'high'
        );
        
        add_meta_box(
            'slider_settings',
            __('Slider Settings', 'conifer-features'),
            array($this, 'slider_settings_callback'),
            'conifer_slider',
            'side',
            'default'
        );
    }
    
    public function slider_images_callback($post) {
        wp_nonce_field('slider_meta_box', 'slider_meta_box_nonce');
        $images = get_post_meta($post->ID, '_slider_images', true);
        ?>
        <div id="slider-images-container">
            <button type="button" id="add-slider-image" class="button"><?php _e('Add Images', 'conifer-features'); ?></button>
            <div id="slider-images-list">
                <?php if ($images): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="slider-image-item">
                            <img src="<?php echo esc_url($image['url']); ?>" style="max-width: 150px; height: auto;">
                            <input type="hidden" name="slider_images[]" value="<?php echo esc_attr($image['id']); ?>">
                            <button type="button" class="remove-slider-image"><?php _e('Remove', 'conifer-features'); ?></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#add-slider-image').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: '<?php _e('Choose Images', 'conifer-features'); ?>',
                    button: {
                        text: '<?php _e('Choose Images', 'conifer-features'); ?>'
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
                            '<button type="button" class="remove-slider-image"><?php _e('Remove', 'conifer-features'); ?></button>' +
                            '</div>'
                        );
                    });
                });
                mediaUploader.open();
            });
            $(document).on('click', '.remove-slider-image', function() {
                $(this).parent().remove();
            });
        });
        </script>
        <?php
    }
    
    public function slider_settings_callback($post) {
        $autoplay = get_post_meta($post->ID, '_slider_autoplay', true);
        $speed = get_post_meta($post->ID, '_slider_speed', true);
        $dots = get_post_meta($post->ID, '_slider_dots', true);
        $arrows = get_post_meta($post->ID, '_slider_arrows', true);
        ?>
        <p>
            <label>
                <input type="checkbox" name="slider_autoplay" value="1" <?php checked($autoplay, 1); ?>>
                <?php _e('Autoplay', 'conifer-features'); ?>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Speed (ms):', 'conifer-features'); ?><br>
                <input type="number" name="slider_speed" value="<?php echo esc_attr($speed ?: 3000); ?>" min="1000" max="10000">
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="slider_dots" value="1" <?php checked($dots, 1); ?>>
                <?php _e('Show Dots', 'conifer-features'); ?>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="slider_arrows" value="1" <?php checked($arrows, 1); ?>>
                <?php _e('Show Arrows', 'conifer-features'); ?>
            </label>
        </p>
        <?php
    }
    
    public function save_slider_meta($post_id) {
        if (!isset($_POST['slider_meta_box_nonce']) || !wp_verify_nonce($_POST['slider_meta_box_nonce'], 'slider_meta_box')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (isset($_POST['post_type']) && 'conifer_slider' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
        
        // Save images
        if (isset($_POST['slider_images'])) {
            $images = array();
            foreach ($_POST['slider_images'] as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                if ($image_url) {
                    $images[] = array('id' => $image_id, 'url' => $image_url);
                }
            }
            update_post_meta($post_id, '_slider_images', $images);
        }
        
        // Save settings
        update_post_meta($post_id, '_slider_autoplay', isset($_POST['slider_autoplay']) ? 1 : 0);
        update_post_meta($post_id, '_slider_speed', sanitize_text_field($_POST['slider_speed']));
        update_post_meta($post_id, '_slider_dots', isset($_POST['slider_dots']) ? 1 : 0);
        update_post_meta($post_id, '_slider_arrows', isset($_POST['slider_arrows']) ? 1 : 0);
    }
    
    public function slider_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
            'class' => '',
        ), $atts);
        
        if (empty($atts['id'])) {
            return '';
        }
        
        $slider = get_post($atts['id']);
        if (!$slider || $slider->post_type !== 'conifer_slider') {
            return '';
        }
        
        $images = get_post_meta($atts['id'], '_slider_images', true);
        $autoplay = get_post_meta($atts['id'], '_slider_autoplay', true);
        $speed = get_post_meta($atts['id'], '_slider_speed', true) ?: 3000;
        $dots = get_post_meta($atts['id'], '_slider_dots', true);
        $arrows = get_post_meta($atts['id'], '_slider_arrows', true);
        
        if (empty($images)) {
            return '';
        }
        
        ob_start();
        ?>
        <div class="conifer-slider <?php echo esc_attr($atts['class']); ?>" 
             data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
             data-speed="<?php echo esc_attr($speed); ?>"
             data-dots="<?php echo $dots ? 'true' : 'false'; ?>"
             data-arrows="<?php echo $arrows ? 'true' : 'false'; ?>">
            <div class="slider-wrapper">
                <?php foreach ($images as $index => $image): ?>
                    <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($slider->post_title); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($arrows): ?>
                <button class="slider-prev">‹</button>
                <button class="slider-next">›</button>
            <?php endif; ?>
            <?php if ($dots): ?>
                <div class="slider-dots">
                    <?php foreach ($images as $index => $image): ?>
                        <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function enqueue_slider_scripts() {
        wp_enqueue_style('conifer-slider-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/slider.css', array(), CONIFER_FEATURES_VERSION);
        wp_enqueue_script('conifer-slider-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/slider.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
    }
}
