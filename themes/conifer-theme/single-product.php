<?php
/**
 * Single product template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="product-<?php the_ID(); ?>" <?php post_class('single-product'); ?>>
                <div class="product-content">
                    <div class="product-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-main-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Get additional product images
                        $gallery_images = get_post_meta(get_the_ID(), '_product_gallery', true);
                        if ($gallery_images) :
                        ?>
                            <div class="product-gallery-thumbs">
                                <?php foreach ($gallery_images as $image_id) : ?>
                                    <div class="gallery-thumb">
                                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-details">
                        <h1 class="product-title"><?php the_title(); ?></h1>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">(4.5) - 12 reviews</span>
                        </div>
                        
                        <div class="product-price">
                            <?php
                            $price = get_post_meta(get_the_ID(), '_product_price', true);
                            $sale_price = get_post_meta(get_the_ID(), '_product_sale_price', true);
                            
                            if ($sale_price && $sale_price < $price) :
                            ?>
                                <span class="current-price">$<?php echo number_format($sale_price, 2); ?></span>
                                <span class="old-price">$<?php echo number_format($price, 2); ?></span>
                                <span class="sale-badge"><?php _e('Sale!', 'conifer'); ?></span>
                            <?php else : ?>
                                <span class="current-price">$<?php echo number_format($price ?: 29.99, 2); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <div class="product-attributes">
                            <?php
                            $attributes = array(
                                'size' => get_post_meta(get_the_ID(), '_product_size', true),
                                'color' => get_post_meta(get_the_ID(), '_product_color', true),
                                'care_level' => get_post_meta(get_the_ID(), '_product_care_level', true),
                            );
                            
                            foreach ($attributes as $key => $value) :
                                if ($value) :
                            ?>
                                <div class="product-attribute">
                                    <strong><?php echo ucfirst(str_replace('_', ' ', $key)); ?>:</strong>
                                    <span><?php echo esc_html($value); ?></span>
                                </div>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                        
                        <div class="product-actions">
                            <div class="quantity-selector">
                                <label for="quantity"><?php _e('Quantity:', 'conifer'); ?></label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                            </div>
                            
                            <button class="add-to-cart-btn" data-product-id="<?php the_ID(); ?>">
                                <i class="fas fa-shopping-cart"></i>
                                <?php _e('Add to Cart', 'conifer'); ?>
                            </button>
                            
                            <button class="add-to-wishlist" data-product-id="<?php the_ID(); ?>">
                                <i class="far fa-heart"></i>
                                <?php _e('Add to Wishlist', 'conifer'); ?>
                            </button>
                        </div>
                        
                        <div class="product-meta">
                            <div class="product-categories">
                                <strong><?php _e('Categories:', 'conifer'); ?></strong>
                                <?php
                                $categories = get_the_terms(get_the_ID(), 'product_category');
                                if ($categories && !is_wp_error($categories)) {
                                    $category_names = array();
                                    foreach ($categories as $category) {
                                        $category_names[] = $category->name;
                                    }
                                    echo implode(', ', $category_names);
                                }
                                ?>
                            </div>
                            
                            <div class="product-tags">
                                <strong><?php _e('Tags:', 'conifer'); ?></strong>
                                <?php
                                $tags = get_the_terms(get_the_ID(), 'product_tag');
                                if ($tags && !is_wp_error($tags)) {
                                    $tag_names = array();
                                    foreach ($tags as $tag) {
                                        $tag_names[] = $tag->name;
                                    }
                                    echo implode(', ', $tag_names);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Tabs -->
                <div class="product-tabs">
                    <ul class="tab-nav">
                        <li class="active"><a href="#description"><?php _e('Description', 'conifer'); ?></a></li>
                        <li><a href="#care-instructions"><?php _e('Care Instructions', 'conifer'); ?></a></li>
                        <li><a href="#reviews"><?php _e('Reviews', 'conifer'); ?></a></li>
                    </ul>
                    
                    <div class="tab-content">
                        <div id="description" class="tab-pane active">
                            <?php the_content(); ?>
                        </div>
                        
                        <div id="care-instructions" class="tab-pane">
                            <?php
                            $care_instructions = get_post_meta(get_the_ID(), '_product_care_instructions', true);
                            if ($care_instructions) {
                                echo wpautop($care_instructions);
                            } else {
                                echo '<p>' . __('Care instructions will be provided with your purchase.', 'conifer') . '</p>';
                            }
                            ?>
                        </div>
                        
                        <div id="reviews" class="tab-pane">
                            <h3><?php _e('Customer Reviews', 'conifer'); ?></h3>
                            <p><?php _e('No reviews yet. Be the first to review this product!', 'conifer'); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Related Products -->
                <div class="related-products">
                    <h3><?php _e('Related Products', 'conifer'); ?></h3>
                    <div class="related-products-grid">
                        <?php
                        $related_products = get_posts(array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'post__not_in' => array(get_the_ID()),
                            'meta_query' => array(
                                array(
                                    'key' => '_product_featured',
                                    'value' => '1',
                                    'compare' => '='
                                )
                            )
                        ));
                        
                        foreach ($related_products as $related) :
                            setup_postdata($related);
                        ?>
                            <div class="related-product">
                                <a href="<?php echo get_permalink($related->ID); ?>">
                                    <?php echo get_the_post_thumbnail($related->ID, 'conifer-product'); ?>
                                    <h4><?php echo get_the_title($related->ID); ?></h4>
                                </a>
                            </div>
                        <?php
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
