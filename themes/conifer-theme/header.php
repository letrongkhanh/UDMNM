<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!-- Header -->
	<header class="header">
		
		<div class="header-main">
			<div class="header-main-content">
					<div class="logo">
                        <div class="cactus-icon">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/demo-store-logo-1578651893.jpg' ); ?>" alt="" srcset="">
                        </div>
						<div class="logo-text">
						</div>
					</div>
					
					<nav class="nav-menu">
						<?php
							// Basic fallback: static links; replace with wp_nav_menu if a menu is assigned
							if ( has_nav_menu('primary') ) {
								wp_nav_menu([
									'theme_location' => 'primary',
									'container' => false,
									'menu_class' => '',
									'items_wrap' => '%3$s'
								]);
							} else {
								// Static fallback to mimic original HTML structure
								?>
                                <a href="<?php echo esc_url( home_url('/') ); ?>" class="active"><?php esc_html_e('HOME', 'conifer-theme-2'); ?></a>
                                <a href="#green-plants"><?php esc_html_e('GREEN PLANTS', 'conifer-theme-2'); ?></a>
                                <a href="<?php echo esc_url( home_url('/contact') ); ?>"><?php esc_html_e('CONTACT US', 'conifer-theme-2'); ?></a>
                                <?php
                                    $posts_page_id = (int) get_option('page_for_posts');
                                    $blog_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
                                ?>
                                <a href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e('BLOG', 'conifer-theme-2'); ?></a>
                                <a href="#more"><?php esc_html_e('MORE', 'conifer-theme-2'); ?></a>
								<?php
							}
						?>
					</nav>
					
					<div class="header-actions">
						<div class="search-icon">
							<i class="fas fa-search"></i>
						</div>
						<div class="account">
							<i class="fas fa-user"></i>
						</div>
						<div class="language-selector">
							<?php if ( function_exists('pll_the_languages') ) : ?>
								<div class="language-dropdown" style="border:none;padding:0;background:transparent;">
									<?php pll_the_languages(['display_names_as' => 'slug', 'show_flags' => 1]); ?>
								</div>
							<?php else : ?>
								<select class="language-dropdown">
									<option value="vi">VN</option>
									<option value="en">EN</option>
								</select>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</header>


