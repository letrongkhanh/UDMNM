<?php
get_header();
?>

<main class="container" style="margin-top:120px; padding:40px 0;">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom:40px;">
				<h1 style="margin-bottom:10px;"><a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;"><?php the_title(); ?></a></h1>
				<div>
					<?php the_excerpt(); ?>
				</div>
			</article>
		<?php endwhile; ?>
		<div class="pagination">
			<?php echo paginate_links(); ?>
		</div>
	<?php else : ?>
		<p><?php esc_html_e('No content found.', 'conifer-theme-2'); ?></p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>


