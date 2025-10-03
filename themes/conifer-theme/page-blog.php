<?php
/* Template Name: Blog Page */
get_header();
?>

	<section class="blog-main">
		<div class="container">
			<div class="blog-header">
				<h1><?php the_title(); ?></h1>
				<p><?php esc_html_e('Discover the latest tips, trends, and insights about indoor plants, gardening, and plant care from our expert team.', 'conifer-theme-2'); ?></p>
			</div>

			<div class="blog-grid">
				<?php
				$paged = get_query_var('paged') ? (int) get_query_var('paged') : 1;
				$query = new WP_Query([
					'post_type' => 'post',
					'paged' => $paged,
				]);
				?>
				<?php if ( $query->have_posts() ) : ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<article class="blog-card">
							<div class="blog-image">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail('large'); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/blog-image.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
								<?php endif; ?>
								<div class="blog-date-badge"><?php echo esc_html( get_the_date('d M') ); ?></div>
							</div>
							<div class="blog-content">
								<div class="blog-category"><?php echo get_the_category_list(', '); ?></div>
								<h2 class="blog-title"><a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;"><?php the_title(); ?></a></h2>
								<p class="blog-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30, '...' ) ); ?></p>
								<div class="blog-meta">
									<div class="blog-author">
										<div class="author-avatar"><?php echo esc_html( strtoupper( substr( get_the_author_meta('display_name'), 0, 1) ) ); ?></div>
										<span class="author-name"><?php the_author(); ?></span>
									</div>
									<a href="<?php the_permalink(); ?>" class="blog-read-more">Read More</a>
								</div>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e('No posts found.', 'conifer-theme-2'); ?></p>
				<?php endif; ?>

				<div class="pagination">
					<?php
						echo paginate_links([
							'total' => $query->max_num_pages,
							'current' => $paged,
							'prev_text' => __('← Previous', 'conifer-theme-2'),
							'next_text' => __('Next →', 'conifer-theme-2'),
						]);
					?>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>


