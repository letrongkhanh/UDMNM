	<!-- Hero Section -->
	<section class="hero">
		<div class="hero-slider">
			<div class="slide active">
				<div class="slide-bg" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/sample-1.jpg' ); ?>')"></div>
				<div class="container">
				</div>
			</div>
			<div class="slide">
				<div class="slide-bg" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/sample-2.jpg' ); ?>')"></div>
				<div class="container">
				</div>
			</div>
		</div>
		<div class="slider-controls">
			<button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
			<button class="next-btn"><i class="fas fa-chevron-right"></i></button>
		</div>
		<div class="slider-dots">
			<span class="dot active" data-slide="0"></span>
			<span class="dot" data-slide="1"></span>
		</div>
	</section>

	<!-- Categories Section -->
	<section class="categories">
		<div class="container">
			<div class="categories-grid">
				<div class="category-item">
					<div class="category-icon">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/61-home_default.jpg' ); ?>" alt="Gift Plant">
					</div>
					<div class="category-divider"></div>
					<h3><?php esc_html_e('GIFT PLANT', 'conifer-theme-2'); ?></h3>
					<p><?php esc_html_e('The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'conifer-theme-2'); ?></p>
				</div>
				
				<div class="category-item">
					<div class="category-icon">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/25-home_default.jpg' ); ?>" alt="Indoor Plants">
					</div>
					<div class="category-divider"></div>
					<h3><?php esc_html_e('INDOOR PLANTS', 'conifer-theme-2'); ?></h3>
					<p><?php esc_html_e('The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'conifer-theme-2'); ?></p>
				</div>
				
				<div class="category-item">
					<div class="category-icon">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/31-home_default.jpg' ); ?>" alt="Rose Plants">
					</div>
					<div class="category-divider"></div>
					<h3><?php esc_html_e('ROSE PLANTS', 'conifer-theme-2'); ?></h3>
					<p><?php esc_html_e('The Point Of Using Lorem Ipsum Is That It Has A More-Or-Less Normal...', 'conifer-theme-2'); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- What We Are Section -->
	<section class="what-we-are">
		<div class="container">
			<div class="what-we-are-content">
				<div class="text-content">
					<h2><?php esc_html_e('What We Are?', 'conifer-theme-2'); ?></h2>
					<p><?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'conifer-theme-2'); ?></p>
					<button class="read-more-btn"><?php esc_html_e('READ MORE', 'conifer-theme-2'); ?></button>
				</div>
				<div class="plants-display">
					<div class="single-plant">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/aboutcms1.png' ); ?>">
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
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/blog-image.jpg' ); ?>">
						<div class="main-blog-overlay">
							<h2><?php esc_html_e('Latest Blog', 'conifer-theme-2'); ?></h2>
							<p><?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'conifer-theme-2'); ?></p>
							<a class="view-all-btn" href="<?php echo esc_url( home_url('/blog') ); ?>"><?php esc_html_e('VIEW ALL BLOG', 'conifer-theme-2'); ?></a>
						</div>
					</div>
				</div>
				
				<div class="blog-grid">
					<div class="blog-item">
						<div class="blog-image">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-4.jpg' ); ?>" alt="Blog 1">
							<div class="date-badge">18 DEC</div>
						</div>
					</div>
					
					<div class="blog-item">
						<div class="blog-image">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-5.jpg' ); ?>" alt="Blog 2">
							<div class="date-badge">18 DEC</div>
						</div>
					</div>
					
					<div class="blog-item">
						<div class="blog-image">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-6.jpg' ); ?>" alt="Blog 3">
							<div class="date-badge">18 DEC</div>
						</div>
					</div>
					
					<div class="blog-item">
						<div class="blog-image">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/b-blog-7.jpg' ); ?>" alt="Blog 4">
							<div class="date-badge">18 DEC</div>
						</div>
					</div>
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
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/3.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
						
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/4.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
						
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/5.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
						
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/6.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
						
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/7.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
						
						<div class="logo-item">
							<div class="logo-icon">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/8.jpg' ); ?>">
							</div>
							<div class="logo-text">
							</div>
						</div>
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
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/testimonial-bkg.jpg' ); ?>">
						<div class="testimonials-overlay">
							<h2><?php esc_html_e('What They Say', 'conifer-theme-2'); ?></h2>
							<div class="divider"></div>
							<p><?php esc_html_e('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s,', 'conifer-theme-2'); ?></p>
							<div class="author-info">
								<h4><?php esc_html_e('LUIES CHARLS', 'conifer-theme-2'); ?></h4>
								<p><?php esc_html_e('Iphone Developer', 'conifer-theme-2'); ?></p>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Get Daily Update -->
				<div class="newsletter-section">
					<div class="newsletter-bg">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/newsletter-bkg.jpg' ); ?>" alt="Get Daily Update Background">
						<div class="newsletter-overlay">
							<h2><?php esc_html_e('Get Daily Update', 'conifer-theme-2'); ?></h2>
							<div class="divider"></div>
							<p><?php esc_html_e('Lorem ipsum dolor, conseetur adipiscing elit, ed doing aliqua Lorem ipsum dolor, constur', 'conifer-theme-2'); ?></p>
							<div class="newsletter-form">
								<input type="email" placeholder="<?php esc_attr_e('Your Email Address', 'conifer-theme-2'); ?>" class="email-input">
								<button class="subscribe-btn"><?php esc_html_e('SUBSCRIBER', 'conifer-theme-2'); ?></button>
							</div>
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
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/service-banner.jpg' ); ?>">
				</div>
				
				<div class="features-grid">
					<div class="feature-item">
						<div class="feature-icon">
							<svg viewBox="0 0 100 100" width="60" height="60">
								<path d="M20 50 L40 30 L60 50 L80 30" stroke="#32CD32" stroke-width="4" fill="none"/>
								<path d="M20 70 L40 50 L60 70 L80 50" stroke="#32CD32" stroke-width="4" fill="none"/>
							</svg>
						</div>
						<h3><?php esc_html_e('BEST QUALITY', 'conifer-theme-2'); ?></h3>
						<p><?php esc_html_e('Praesent pulvinar neque pellente mattis pretium.', 'conifer-theme-2'); ?></p>
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
						<h3><?php esc_html_e('ON TIME DELIVERY', 'conifer-theme-2'); ?></h3>
						<p><?php esc_html_e('Praesent pulvinar neque pellente mattis pretium.', 'conifer-theme-2'); ?></p>
					</div>
					
					<div class="feature-item">
						<div class="feature-icon">
							<svg viewBox="0 0 100 100" width="60" height="60">
								<circle cx="50" cy="40" r="20" fill="#32CD32"/>
								<path d="M30 60 Q50 80 70 60" stroke="#32CD32" stroke-width="4" fill="none"/>
								<rect x="45" y="25" width="10" height="15" fill="white"/>
							</svg>
						</div>
						<h3><?php esc_html_e('ONLINE SUPPORT', 'conifer-theme-2'); ?></h3>
						<p><?php esc_html_e('Praesent pulvinar neque pellente mattis pretium.', 'conifer-theme-2'); ?></p>
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
						<h3><?php esc_html_e('QUALITY SUPPORT', 'conifer-theme-2'); ?></h3>
						<p><?php esc_html_e('Praesent pulvinar neque pellente mattis pretium.', 'conifer-theme-2'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>


