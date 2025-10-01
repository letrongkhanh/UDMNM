<?php
/**
 * Product archive template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php _e('Our Products', 'conifer'); ?></h1>
            <p><?php _e('Discover our wide range of beautiful plants and gardening supplies.', 'conifer'); ?></p>
        </header>
        
        <div class="products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('conifer-product'); ?>
                            <?php else : ?>
                                <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/product-placeholder.jpg" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            
                            <div class="product-overlay">
                                <button class="quick-view" data-product-id="<?php the_ID(); ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="add-to-cart" data-product-id="<?php the_ID(); ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(4.5)</span>
                            </div>
                            
                            <div class="product-price">
                                <?php
                                $price = get_post_meta(get_the_ID(), '_product_price', true);
                                $sale_price = get_post_meta(get_the_ID(), '_product_sale_price', true);
                                
                                if ($sale_price && $sale_price < $price) :
                                ?>
                                    <span class="current-price">$<?php echo number_format($sale_price, 2); ?></span>
                                    <span class="old-price">$<?php echo number_format($price, 2); ?></span>
                                <?php else : ?>
                                    <span class="current-price">$<?php echo number_format($price ?: 29.99, 2); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <?php
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'conifer'),
                    'next_text' => __('Next', 'conifer'),
                ));
                ?>
                
            <?php else : ?>
                <div class="no-products">
                    <h2><?php _e('No Products Found', 'conifer'); ?></h2>
                    <p><?php _e('Sorry, no products were found matching your criteria.', 'conifer'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
