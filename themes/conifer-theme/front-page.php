<?php
/**
 * The front page template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-slider">
            <?php
            $hero_slides = conifer_get_hero_slides();
            if (empty($hero_slides)) {
                // Default slides
                $default_slides = array(
                    array('image' => CONIFER_THEME_URL . '/assets/images/sample-1.jpg'),
                    array('image' => CONIFER_THEME_URL . '/assets/images/sample-2.jpg'),
                );
                $hero_slides = $default_slides;
            }
            
            foreach ($hero_slides as $index => $slide) :
                $image_url = is_array($slide) ? $slide['image'] : wp_get_attachment_image_url($slide->ID, 'conifer-hero');
            ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="slide-bg" style="background-image: url('<?php echo esc_url($image_url); ?>')"></div>
                    <div class="container">
                        <div class="hero-content">
                            <h1><?php echo get_theme_mod('conifer_hero_title', __('Welcome to Conifer', 'conifer')); ?></h1>
                            <p><?php echo get_theme_mod('conifer_hero_subtitle', __('Your trusted plant store', 'conifer')); ?></p>
                            <div class="hero-buttons">
                                <a href="<?php echo get_permalink(get_page_by_path('products')); ?>" class="btn btn-primary"><?php _e('Shop Now', 'conifer'); ?></a>
                                <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" class="btn btn-outline"><?php _e('Learn More', 'conifer'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="slider-controls">
            <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
        
        <div class="slider-dots">
            <?php for ($i = 0; $i < count($hero_slides); $i++) : ?>
                <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <div class="categories-grid">
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'product_category',
                    'hide_empty' => false,
                    'number' => 3,
                ));
                
                if (empty($categories)) {
                    // Default categories
                    $default_categories = array(
                        array('name' => 'Gift Plant', 'description' => 'The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'image' => CONIFER_THEME_URL . '/assets/images/61-home_default.jpg'),
                        array('name' => 'Indoor Plants', 'description' => 'The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'image' => CONIFER_THEME_URL . '/assets/images/25-home_default.jpg'),
                        array('name' => 'Rose Plants', 'description' => 'The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'image' => CONIFER_THEME_URL . '/assets/images/31-home_default.jpg'),
                    );
                    $categories = $default_categories;
                }
                
                foreach ($categories as $category) :
                    $image_url = is_object($category) ? get_term_meta($category->term_id, 'category_image', true) : $category['image'];
                    $name = is_object($category) ? $category->name : $category['name'];
                    $description = is_object($category) ? $category->description : $category['description'];
                ?>
                    <div class="category-item">
                        <div class="category-icon">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>">
                        </div>
                        <div class="category-divider"></div>
                        <h3><?php echo esc_html($name); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- What We Are Section -->
    <section class="what-we-are">
        <div class="container">
            <div class="what-we-are-content">
                <div class="text-content">
                    <h2><?php _e('What We Are?', 'conifer'); ?></h2>
                    <p><?php echo get_theme_mod('conifer_about_text', __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'conifer')); ?></p>
                    <button class="read-more-btn"><?php _e('READ MORE', 'conifer'); ?></button>
                </div>
                <div class="plants-display">
                    <div class="single-plant">
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/aboutcms1.png" alt="<?php _e('About Us', 'conifer'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Section -->
    <section class="latest-blog">
        <div class="container">
            <div class="blog-content">
                <div class="main-blog">
                    <div class="main-blog-bg">
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/blog-image.jpg" alt="<?php _e('Latest Blog', 'conifer'); ?>">
                        <div class="main-blog-overlay">
                            <h2><?php _e('Latest Blog', 'conifer'); ?></h2>
                            <p><?php _e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'conifer'); ?></p>
                            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="view-all-btn"><?php _e('VIEW ALL BLOG', 'conifer'); ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-grid">
                    <?php
                    $latest_posts = conifer_get_latest_posts(4);
                    foreach ($latest_posts as $post) :
                        setup_postdata($post);
                    ?>
                        <div class="blog-item">
                            <div class="blog-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('conifer-blog'); ?>
                                <?php else : ?>
                                    <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/b-blog-<?php echo (4 + $post->ID % 4); ?>.jpg" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                <div class="date-badge"><?php echo get_the_date('j M'); ?></div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Logos Section -->
    <section class="brand-logos">
        <div class="container">
            <div class="logos-slider">
                <button class="logo-nav prev-logo">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <div class="logos-container">
                    <div class="logos-track" id="logosTrack">
                        <?php
                        $brand_images = array(
                            CONIFER_THEME_URL . '/assets/images/3.jpg',
                            CONIFER_THEME_URL . '/assets/images/4.jpg',
                            CONIFER_THEME_URL . '/assets/images/5.jpg',
                            CONIFER_THEME_URL . '/assets/images/6.jpg',
                            CONIFER_THEME_URL . '/assets/images/7.jpg',
                            CONIFER_THEME_URL . '/assets/images/8.jpg',
                        );
                        
                        foreach ($brand_images as $image) :
                        ?>
                            <div class="logo-item">
                                <div class="logo-icon">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php _e('Brand', 'conifer'); ?>">
                                </div>
                                <div class="logo-text">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button class="logo-nav next-logo">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonials & Newsletter Section -->
    <section class="testimonials-newsletter">
        <div class="container">
            <div class="two-column-layout">
                <!-- What They Say -->
                <div class="testimonials-section">
                    <div class="testimonials-bg">
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/testimonial-bkg.jpg" alt="<?php _e('Testimonials', 'conifer'); ?>">
                        <div class="testimonials-overlay">
                            <h2><?php _e('What They Say', 'conifer'); ?></h2>
                            <div class="divider"></div>
                            <p><?php _e('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s,', 'conifer'); ?></p>
                            <div class="author-info">
                                <h4><?php _e('LUIES CHARLS', 'conifer'); ?></h4>
                                <p><?php _e('Iphone Developer', 'conifer'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Get Daily Update -->
                <div class="newsletter-section">
                    <div class="newsletter-bg">
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/newsletter-bkg.jpg" alt="<?php _e('Newsletter', 'conifer'); ?>">
                        <div class="newsletter-overlay">
                            <h2><?php _e('Get Daily Update', 'conifer'); ?></h2>
                            <div class="divider"></div>
                            <p><?php _e('Lorem ipsum dolor, conseetur adipiscing elit, ed doing aliqua Lorem ipsum dolor, constur', 'conifer'); ?></p>
                            <form class="newsletter-form" id="newsletter-form">
                                <input type="email" name="email" placeholder="<?php _e('Your Email Address', 'conifer'); ?>" class="email-input" required>
                                <button type="submit" class="subscribe-btn"><?php _e('SUBSCRIBER', 'conifer'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-content">
                <div class="features-image">
                    <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/service-banner.jpg" alt="<?php _e('Features', 'conifer'); ?>">
                </div>
                
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 100 100" width="60" height="60">
                                <path d="M20 50 L40 30 L60 50 L80 30" stroke="#32CD32" stroke-width="4" fill="none"/>
                                <path d="M20 70 L40 50 L60 70 L80 50" stroke="#32CD32" stroke-width="4" fill="none"/>
                            </svg>
                        </div>
                        <h3><?php _e('BEST QUALITY', 'conifer'); ?></h3>
                        <p><?php _e('Praesent pulvinar neque pellente mattis pretium.', 'conifer'); ?></p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 100 100" width="60" height="60">
                                <rect x="20" y="40" width="60" height="30" rx="5" fill="#32CD32"/>
                                <rect x="25" y="35" width="50" height="20" rx="3" fill="#32CD32"/>
                                <circle cx="30" cy="45" r="3" fill="white"/>
                                <circle cx="70" cy="45" r="3" fill="white"/>
                                <text x="50" y="52" text-anchor="middle" fill="white" font-size="8" font-weight="bold">FREE</text>
                            </svg>
                        </div>
                        <h3><?php _e('ON TIME DELIVERY', 'conifer'); ?></h3>
                        <p><?php _e('Praesent pulvinar neque pellente mattis pretium.', 'conifer'); ?></p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 100 100" width="60" height="60">
                                <circle cx="50" cy="40" r="20" fill="#32CD32"/>
                                <path d="M30 60 Q50 80 70 60" stroke="#32CD32" stroke-width="4" fill="none"/>
                                <rect x="45" y="25" width="10" height="15" fill="white"/>
                            </svg>
                        </div>
                        <h3><?php _e('ONLINE SUPPORT', 'conifer'); ?></h3>
                        <p><?php _e('Praesent pulvinar neque pellente mattis pretium.', 'conifer'); ?></p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 100 100" width="60" height="60">
                                <path d="M30 60 L40 50 L50 60 L70 40" stroke="#32CD32" stroke-width="6" fill="none" stroke-linecap="round"/>
                                <circle cx="30" cy="60" r="3" fill="#32CD32"/>
                                <circle cx="40" cy="50" r="3" fill="#32CD32"/>
                                <circle cx="50" cy="60" r="3" fill="#32CD32"/>
                                <circle cx="70" cy="40" r="3" fill="#32CD32"/>
                            </svg>
                        </div>
                        <h3><?php _e('QUALITY SUPPORT', 'conifer'); ?></h3>
                        <p><?php _e('Praesent pulvinar neque pellente mattis pretium.', 'conifer'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
