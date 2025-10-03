<?php
/* Blog index converted from blog.html */
get_header();
?>

	<!-- Blog Content -->
	<section class="blog-main">
		<div class="container">
			<!-- Blog Header -->
			<div class="blog-header">
				<h1><?php echo esc_html( get_the_title( get_option('page_for_posts', true) ) ?: 'Latest Blog Posts' ); ?></h1>
				<p><?php esc_html_e('Discover the latest tips, trends, and insights about indoor plants, gardening, and plant care from our expert team.', 'conifer-theme-2'); ?></p>
			</div>

			<!-- Blog Grid -->
			<div class="blog-grid">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
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
					<?php endwhile; ?>
				<?php else : ?>
					<!-- Fallback demo posts to resemble blog.html when no posts exist -->
					<article class="blog-card">
						<div class="blog-image">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/blog-image.jpg' ); ?>" alt="Indoor Plant Care Guide">
							<div class="blog-date-badge">18 DEC</div>
						</div>
						<div class="blog-content">
							<div class="blog-category">Plant Care</div>
							<h2 class="blog-title">Complete Guide to Indoor Plant Care</h2>
							<p class="blog-excerpt">Learn the essential tips and tricks for keeping your indoor plants healthy and thriving. From watering schedules to proper lighting, we cover everything you need to know.</p>
							<div class="blog-meta">
								<div class="blog-author">
									<div class="author-avatar">LC</div>
									<span class="author-name">Luis Charles</span>
								</div>
								<a href="#" class="blog-read-more">Read More</a>
							</div>
						</div>
					</article>

					<article class="blog-card">
						<div class="blog-image">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-4.jpg' ); ?>" alt="Best Indoor Plants for Beginners">
							<div class="blog-date-badge">15 DEC</div>
						</div>
						<div class="blog-content">
							<div class="blog-category">Plant Selection</div>
							<h2 class="blog-title">Best Indoor Plants for Beginners</h2>
							<p class="blog-excerpt">Starting your plant journey? Here are the most forgiving and easy-to-care-for indoor plants that are perfect for beginners and busy lifestyles.</p>
							<div class="blog-meta">
								<div class="blog-author">
									<div class="author-avatar">SM</div>
									<span class="author-name">Sarah Miller</span>
								</div>
								<a href="#" class="blog-read-more">Read More</a>
							</div>
						</div>
					</article>

					<article class="blog-card">
						<div class="blog-image">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-5.jpg' ); ?>" alt="Plant Potting and Repotting">
							<div class="blog-date-badge">12 DEC</div>
						</div>
						<div class="blog-content">
							<div class="blog-category">Gardening Tips</div>
							<h2 class="blog-title">Plant Potting and Repotting Guide</h2>
							<p class="blog-excerpt">Master the art of potting and repotting your plants. Learn when and how to repot, choose the right soil, and select the perfect pot for your green friends.</p>
							<div class="blog-meta">
								<div class="blog-author">
									<div class="author-avatar">MJ</div>
									<span class="author-name">Mike Johnson</span>
								</div>
								<a href="#" class="blog-read-more">Read More</a>
							</div>
						</div>
					</article>

					<article class="blog-card">
						<div class="blog-image">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-6.jpg' ); ?>" alt="Seasonal Plant Care">
							<div class="blog-date-badge">10 DEC</div>
						</div>
						<div class="blog-content">
							<div class="blog-category">Seasonal Care</div>
							<h2 class="blog-title">Seasonal Plant Care Calendar</h2>
							<p class="blog-excerpt">Follow our comprehensive seasonal care calendar to ensure your plants thrive throughout the year. From spring growth to winter dormancy.</p>
							<div class="blog-meta">
								<div class="blog-author">
									<div class="author-avatar">AL</div>
									<span class="author-name">Anna Lee</span>
								</div>
								<a href="#" class="blog-read-more">Read More</a>
							</div>
						</div>
					</article>

					<article class="blog-card">
						<div class="blog-image">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-7.jpg' ); ?>" alt="Plant Disease Prevention">
							<div class="blog-date-badge">08 DEC</div>
						</div>
						<div class="blog-content">
							<div class="blog-category">Plant Health</div>
							<h2 class="blog-title">Preventing Common Plant Diseases</h2>
							<p class="blog-excerpt">Learn how to identify, prevent, and treat common plant diseases. Keep your plants healthy with our expert advice on disease prevention.</p>
							<div class="blog-meta">
								<div class="blog-author">
									<div class="author-avatar">DR</div>
									<span class="author-name">David Rodriguez</span>
								</div>
								<a href="#" class="blog-read-more">Read More</a>
							</div>
						</div>
					</article>
				<?php endif; ?>

				<!-- Pagination -->
				<div class="pagination">
					<?php
						echo paginate_links([
							'prev_text' => __('← Previous', 'conifer-theme-2'),
							'next_text' => __('Next →', 'conifer-theme-2'),
						]);
					?>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>


