<?php
/**
 * Single post template
 *
 * @package Conifer
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <span class="post-date">
                            <i class="fas fa-calendar"></i>
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="post-author">
                            <i class="fas fa-user"></i>
                            <?php the_author(); ?>
                        </span>
                        <span class="post-categories">
                            <i class="fas fa-folder"></i>
                            <?php the_category(', '); ?>
                        </span>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="post-footer">
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <h4><?php _e('Tags:', 'conifer'); ?></h4>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-navigation">
                        <?php
                        the_post_navigation(array(
                            'prev_text' => '<i class="fas fa-arrow-left"></i> ' . __('Previous Post', 'conifer'),
                            'next_text' => __('Next Post', 'conifer') . ' <i class="fas fa-arrow-right"></i>',
                        ));
                        ?>
                    </div>
                </footer>
            </article>
            
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
