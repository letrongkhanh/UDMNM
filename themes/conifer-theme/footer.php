<?php
/**
 * The footer template
 *
 * @package Conifer
 * @version 1.0.0
 */
?>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/footer-logo.png" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                </div>
                <p><?php echo get_theme_mod('conifer_footer_description', __('Your trusted online shopping destination for quality products at great prices. We offer fast shipping, secure payments, and excellent customer service.', 'conifer')); ?></p>
                <div class="social-links">
                    <?php
                    $social_links = array(
                        'facebook' => get_theme_mod('conifer_facebook_url', '#'),
                        'instagram' => get_theme_mod('conifer_instagram_url', '#'),
                        'twitter' => get_theme_mod('conifer_twitter_url', '#'),
                        'youtube' => get_theme_mod('conifer_youtube_url', '#'),
                    );
                    
                    foreach ($social_links as $platform => $url) :
                        if ($url && $url !== '#') :
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                        </a>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            
            <div class="footer-section">
                <h4><?php _e('Quick Links', 'conifer'); ?></h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                    'fallback_cb' => false,
                ));
                ?>
            </div>
            
            <div class="footer-section">
                <h4><?php _e('Customer Service', 'conifer'); ?></h4>
                <ul>
                    <li><a href="<?php echo get_permalink(get_page_by_path('contact')); ?>"><?php _e('Contact Us', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Shipping Info', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Returns', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('FAQ', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Size Guide', 'conifer'); ?></a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4><?php _e('My Account', 'conifer'); ?></h4>
                <ul>
                    <li><a href="#"><?php _e('My Account', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Order History', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Wishlist', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Newsletter', 'conifer'); ?></a></li>
                    <li><a href="#"><?php _e('Specials', 'conifer'); ?></a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4><?php _e('Contact Info', 'conifer'); ?></h4>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo get_theme_mod('conifer_address', '41 Nguyen Hue, Hue City, Vietnam'); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo get_theme_mod('conifer_phone', '+84 905 567 890'); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo get_theme_mod('conifer_email', 'info@conifer.com'); ?></p>
                    <p><i class="fas fa-clock"></i> <?php _e('Mon - Fri: 9:00 AM - 6:00 PM', 'conifer'); ?></p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'conifer'); ?></p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-cc-amex"></i>
                <i class="fab fa-cc-discover"></i>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
