<?php
/**
 * Blog page template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Blog Page Header -->
    <section class="blog-header">
        <div class="container">
            <h1><?php _e('Latest Blog Posts', 'conifer'); ?></h1>
            <p><?php _e('Discover the latest tips, trends, and insights about indoor plants, gardening, and plant care from our expert team.', 'conifer'); ?></p>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="blog-main">
        <div class="container">
            <div class="blog-grid">
                <?php
                $blog_posts = get_posts(array(
                    'post_type' => 'post',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                ));
                
                if (empty($blog_posts)) {
                    // Default blog posts
                    $default_posts = array(
                        array(
                            'title' => 'Complete Guide to Indoor Plant Care',
                            'excerpt' => 'Learn the essential tips and tricks for keeping your indoor plants healthy and thriving. From watering schedules to proper lighting, we cover everything you need to know.',
                            'date' => '18 DEC',
                            'category' => 'Plant Care',
                            'author' => 'Luis Charles',
                            'image' => CONIFER_THEME_URL . '/assets/images/blog-image.jpg',
                        ),
                        array(
                            'title' => 'Best Indoor Plants for Beginners',
                            'excerpt' => 'Starting your plant journey? Here are the most forgiving and easy-to-care-for indoor plants that are perfect for beginners and busy lifestyles.',
                            'date' => '15 DEC',
                            'category' => 'Plant Selection',
                            'author' => 'Sarah Miller',
                            'image' => CONIFER_THEME_URL . '/assets/images/b-blog-4.jpg',
                        ),
                        array(
                            'title' => 'Plant Potting and Repotting Guide',
                            'excerpt' => 'Master the art of potting and repotting your plants. Learn when and how to repot, choose the right soil, and select the perfect pot for your green friends.',
                            'date' => '12 DEC',
                            'category' => 'Gardening Tips',
                            'author' => 'Mike Johnson',
                            'image' => CONIFER_THEME_URL . '/assets/images/b-blog-5.jpg',
                        ),
                        array(
                            'title' => 'Seasonal Plant Care Calendar',
                            'excerpt' => 'Follow our comprehensive seasonal care calendar to ensure your plants thrive throughout the year. From spring growth to winter dormancy.',
                            'date' => '10 DEC',
                            'category' => 'Seasonal Care',
                            'author' => 'Anna Lee',
                            'image' => CONIFER_THEME_URL . '/assets/images/b-blog-6.jpg',
                        ),
                        array(
                            'title' => 'Preventing Common Plant Diseases',
                            'excerpt' => 'Learn how to identify, prevent, and treat common plant diseases. Keep your plants healthy with our expert advice on disease prevention.',
                            'date' => '08 DEC',
                            'category' => 'Plant Health',
                            'author' => 'David Rodriguez',
                            'image' => CONIFER_THEME_URL . '/assets/images/b-blog-7.jpg',
                        ),
                    );
                    $blog_posts = $default_posts;
                }
                
                foreach ($blog_posts as $index => $post) :
                    $title = is_object($post) ? $post->post_title : $post['title'];
                    $excerpt = is_object($post) ? wp_trim_words($post->post_content, 20) : $post['excerpt'];
                    $date = is_object($post) ? get_the_date('j M', $post) : $post['date'];
                    $category = is_object($post) ? get_the_category($post->ID)[0]->name : $post['category'];
                    $author = is_object($post) ? get_the_author_meta('display_name', $post->post_author) : $post['author'];
                    $image = is_object($post) ? get_the_post_thumbnail_url($post->ID, 'conifer-blog') : $post['image'];
                    $permalink = is_object($post) ? get_permalink($post->ID) : '#';
                ?>
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="blog-date-badge"><?php echo esc_html($date); ?></div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-category"><?php echo esc_html($category); ?></div>
                            <h2 class="blog-title"><?php echo esc_html($title); ?></h2>
                            <p class="blog-excerpt"><?php echo esc_html($excerpt); ?></p>
                            <div class="blog-meta">
                                <div class="blog-author">
                                    <div class="author-avatar"><?php echo strtoupper(substr($author, 0, 2)); ?></div>
                                    <span class="author-name"><?php echo esc_html($author); ?></span>
                                </div>
                                <a href="<?php echo esc_url($permalink); ?>" class="blog-read-more"><?php _e('Read More', 'conifer'); ?></a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#"><?php _e('Next', 'conifer'); ?> →</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
