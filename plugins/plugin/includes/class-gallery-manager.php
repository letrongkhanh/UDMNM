<?php
/**
 * Class quản lý gallery
 */
class Gallery_Manager {
    
    public function __construct() {
        add_action('init', array($this, 'create_gallery_post_type'));
        add_action('add_meta_boxes', array($this, 'add_gallery_meta_boxes'));
        add_action('save_post', array($this, 'save_gallery_meta'));
        add_shortcode('conifer_gallery', array($this, 'gallery_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_gallery_scripts'));
    }
    
    public function create_gallery_post_type() {
        register_post_type('conifer_gallery', array(
            'labels' => array(
                'name' => __('Galleries', 'conifer-features'),
                'singular_name' => __('Gallery', 'conifer-features'),
                'add_new' => __('Add New Gallery', 'conifer-features'),
                'add_new_item' => __('Add New Gallery', 'conifer-features'),
                'edit_item' => __('Edit Gallery', 'conifer-features'),
                'new_item' => __('New Gallery', 'conifer-features'),
                'view_item' => __('View Gallery', 'conifer-features'),
                'search_items' => __('Search Galleries', 'conifer-features'),
                'not_found' => __('No galleries found', 'conifer-features'),
                'not_found_in_trash' => __('No galleries found in Trash', 'conifer-features'),
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-format-gallery',
        ));
    }
    
    public function add_gallery_meta_boxes() {
        add_meta_box(
            'gallery_images',
            __('Gallery Images', 'conifer-features'),
            array($this, 'gallery_images_callback'),
            'conifer_gallery',
            'normal',
            'high'
        );
        
        add_meta_box(
            'gallery_settings',
            __('Gallery Settings', 'conifer-features'),
            array($this, 'gallery_settings_callback'),
            'conifer_gallery',
            'side',
            'default'
        );
    }
    
    public function gallery_images_callback($post) {
        wp_nonce_field('gallery_meta_box', 'gallery_meta_box_nonce');
        $images = get_post_meta($post->ID, '_gallery_images', true);
        ?>
        <div id="gallery-images-container">
            <button type="button" id="add-gallery-image" class="button"><?php _e('Add Images', 'conifer-features'); ?></button>
            <div id="gallery-images-list">
                <?php if ($images): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="gallery-image-item">
                            <img src="<?php echo esc_url($image['url']); ?>" style="max-width: 150px; height: auto;">
                            <input type="hidden" name="gallery_images[]" value="<?php echo esc_attr($image['id']); ?>">
                            <button type="button" class="remove-gallery-image"><?php _e('Remove', 'conifer-features'); ?></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#add-gallery-image').click(function(e) {
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
                        $('#gallery-images-list').append(
                            '<div class="gallery-image-item">' +
                            '<img src="' + attachment.url + '" style="max-width: 150px; height: auto;">' +
                            '<input type="hidden" name="gallery_images[]" value="' + attachment.id + '">' +
                            '<button type="button" class="remove-gallery-image"><?php _e('Remove', 'conifer-features'); ?></button>' +
                            '</div>'
                        );
                    });
                });
                mediaUploader.open();
            });
            $(document).on('click', '.remove-gallery-image', function() {
                $(this).parent().remove();
            });
        });
        </script>
        <?php
    }
    
    public function gallery_settings_callback($post) {
        $columns = get_post_meta($post->ID, '_gallery_columns', true);
        $lightbox = get_post_meta($post->ID, '_gallery_lightbox', true);
        $show_captions = get_post_meta($post->ID, '_gallery_show_captions', true);
        $image_size = get_post_meta($post->ID, '_gallery_image_size', true);
        ?>
        <p>
            <label>
                <?php _e('Columns:', 'conifer-features'); ?><br>
                <select name="gallery_columns">
                    <option value="1" <?php selected($columns, 1); ?>><?php _e('1 Column', 'conifer-features'); ?></option>
                    <option value="2" <?php selected($columns, 2); ?>><?php _e('2 Columns', 'conifer-features'); ?></option>
                    <option value="3" <?php selected($columns, 3); ?>><?php _e('3 Columns', 'conifer-features'); ?></option>
                    <option value="4" <?php selected($columns, 4); ?>><?php _e('4 Columns', 'conifer-features'); ?></option>
                    <option value="5" <?php selected($columns, 5); ?>><?php _e('5 Columns', 'conifer-features'); ?></option>
                </select>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="gallery_lightbox" value="1" <?php checked($lightbox, 1); ?>>
                <?php _e('Enable Lightbox', 'conifer-features'); ?>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="gallery_show_captions" value="1" <?php checked($show_captions, 1); ?>>
                <?php _e('Show Captions', 'conifer-features'); ?>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Image Size:', 'conifer-features'); ?><br>
                <select name="gallery_image_size">
                    <option value="thumbnail" <?php selected($image_size, 'thumbnail'); ?>><?php _e('Thumbnail', 'conifer-features'); ?></option>
                    <option value="medium" <?php selected($image_size, 'medium'); ?>><?php _e('Medium', 'conifer-features'); ?></option>
                    <option value="large" <?php selected($image_size, 'large'); ?>><?php _e('Large', 'conifer-features'); ?></option>
                    <option value="full" <?php selected($image_size, 'full'); ?>><?php _e('Full Size', 'conifer-features'); ?></option>
                </select>
            </label>
        </p>
        <?php
    }
    
    public function save_gallery_meta($post_id) {
        if (!isset($_POST['gallery_meta_box_nonce']) || !wp_verify_nonce($_POST['gallery_meta_box_nonce'], 'gallery_meta_box')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (isset($_POST['post_type']) && 'conifer_gallery' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
        
        // Save images
        if (isset($_POST['gallery_images'])) {
            $images = array();
            foreach ($_POST['gallery_images'] as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                if ($image_url) {
                    $images[] = array('id' => $image_id, 'url' => $image_url);
                }
            }
            update_post_meta($post_id, '_gallery_images', $images);
        }
        
        // Save settings
        update_post_meta($post_id, '_gallery_columns', sanitize_text_field($_POST['gallery_columns']));
        update_post_meta($post_id, '_gallery_lightbox', isset($_POST['gallery_lightbox']) ? 1 : 0);
        update_post_meta($post_id, '_gallery_show_captions', isset($_POST['gallery_show_captions']) ? 1 : 0);
        update_post_meta($post_id, '_gallery_image_size', sanitize_text_field($_POST['gallery_image_size']));
    }
    
    public function gallery_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
            'class' => '',
        ), $atts);
        
        if (empty($atts['id'])) {
            return '';
        }
        
        $gallery = get_post($atts['id']);
        if (!$gallery || $gallery->post_type !== 'conifer_gallery') {
            return '';
        }
        
        $images = get_post_meta($atts['id'], '_gallery_images', true);
        $columns = get_post_meta($atts['id'], '_gallery_columns', true) ?: 3;
        $lightbox = get_post_meta($atts['id'], '_gallery_lightbox', true);
        $show_captions = get_post_meta($atts['id'], '_gallery_show_captions', true);
        $image_size = get_post_meta($atts['id'], '_gallery_image_size', true) ?: 'medium';
        
        if (empty($images)) {
            return '';
        }
        
        ob_start();
        ?>
        <div class="conifer-gallery <?php echo esc_attr($atts['class']); ?>" 
             data-columns="<?php echo esc_attr($columns); ?>"
             data-lightbox="<?php echo $lightbox ? 'true' : 'false'; ?>">
            <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(<?php echo esc_attr($columns); ?>, 1fr); gap: 10px;">
                <?php foreach ($images as $index => $image): ?>
                    <div class="gallery-item">
                        <?php if ($lightbox): ?>
                            <a href="<?php echo esc_url($image['url']); ?>" class="gallery-lightbox" data-lightbox="gallery-<?php echo esc_attr($atts['id']); ?>">
                                <?php echo wp_get_attachment_image($image['id'], $image_size); ?>
                            </a>
                        <?php else: ?>
                            <?php echo wp_get_attachment_image($image['id'], $image_size); ?>
                        <?php endif; ?>
                        
                        <?php if ($show_captions): ?>
                            <?php 
                            $caption = wp_get_attachment_caption($image['id']);
                            if ($caption): ?>
                                <div class="gallery-caption"><?php echo esc_html($caption); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function enqueue_gallery_scripts() {
        wp_enqueue_style('conifer-gallery-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/gallery.css', array(), CONIFER_FEATURES_VERSION);
        wp_enqueue_script('conifer-gallery-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/gallery.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
        
        // Enqueue lightbox if needed
        if (get_post_meta(get_the_ID(), '_gallery_lightbox', true)) {
            wp_enqueue_style('lightbox-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/lightbox.css', array(), CONIFER_FEATURES_VERSION);
            wp_enqueue_script('lightbox-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/lightbox.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
        }
    }
}
