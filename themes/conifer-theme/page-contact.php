<?php
/* Template Name: Contact Page */
get_header();
?>

	<!-- Contact Page Header -->
	<section class="contact-header">
		<div class="container">
			<h1><?php esc_html_e('CONTACT US', 'conifer-theme-2'); ?></h1>
			<nav class="breadcrumb">
				<span><?php esc_html_e('CONTACT US', 'conifer-theme-2'); ?></span>
			</nav>
		</div>
	</section>

	<!-- Contact Content -->
	<section class="contact-main">
		<div class="container">
			<div class="contact-layout">
				<!-- Store Information -->
				<div class="store-info">
					<h2><?php esc_html_e('Store Information', 'conifer-theme-2'); ?></h2>
					<div class="info-divider"></div>
					
					<div class="info-item">
						<div class="info-icon">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div class="info-content">
						<p><?php esc_html_e('Hue City, Vietnam', 'conifer-theme-2'); ?></p>
						<p><?php esc_html_e('France', 'conifer-theme-2'); ?></p>
						</div>
					</div>
					
					<div class="info-item">
						<div class="info-icon">
							<i class="fas fa-phone"></i>
						</div>
						<div class="info-content">
						<p><?php esc_html_e('Call us:', 'conifer-theme-2'); ?></p>
							<p>+84 905 567 890</p>
						</div>
					</div>
					
					<div class="info-item">
						<div class="info-icon">
							<i class="fas fa-fax"></i>
						</div>
						<div class="info-content">
						<p><?php esc_html_e('Fax:', 'conifer-theme-2'); ?></p>
							<p>123456</p>
						</div>
					</div>
					
					<div class="info-item">
						<div class="info-icon">
							<i class="fas fa-envelope"></i>
						</div>
						<div class="info-content">
						<p><?php esc_html_e('Email us:', 'conifer-theme-2'); ?></p>
							<p>info@prestashop.com</p>
						</div>
					</div>
				</div>

				<!-- Contact Form -->
				<div class="contact-form">
					<form class="form" method="post" action="#">
						<div class="form-row">
							<div class="form-group">
								<input type="text" id="name" name="name" class="form-control" placeholder="Your Name">
							</div>
							<div class="form-group">
								<input type="email" id="email" name="email" class="form-control" placeholder="Your Email">
							</div>
						</div>
						
						<div class="form-group">
							<input type="text" id="subject" name="subject" class="form-control" placeholder="Subject">
						</div>
						
						<div class="form-group">
							<textarea id="message" name="message" class="form-control textarea" placeholder="Message" rows="5"></textarea>
						</div>
						
						<button type="submit" class="send-btn"><?php esc_html_e('Send Message', 'conifer-theme-2'); ?></button>
					</form>
				</div>
			</div>
		</div>
	</section>
	
<?php get_footer(); ?>


