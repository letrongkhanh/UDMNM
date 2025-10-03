	<!-- Footer -->
	<footer class="footer">
		<div class="container">
			<div class="footer-content">
				<div class="footer-section">
					<div class="footer-logo">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/footer-logo.png' ); ?>" alt="PrestaShop">
					</div>
					<p>Your trusted online shopping destination for quality products at great prices. We offer fast shipping, secure payments, and excellent customer service.</p>
					<div class="social-links">
						<a href="#"><i class="fab fa-facebook"></i></a>
						<a href="#"><i class="fab fa-instagram"></i></a>
						<a href="#"><i class="fab fa-twitter"></i></a>
						<a href="#"><i class="fab fa-youtube"></i></a>
					</div>
				</div>
				
				<div class="footer-section">
					<h4><?php esc_html_e('Quick Links', 'conifer-theme-2'); ?></h4>
					<ul>
						<li><a href="#home"><?php esc_html_e('Home', 'conifer-theme-2'); ?></a></li>
						<li><a href="#products"><?php esc_html_e('Products', 'conifer-theme-2'); ?></a></li>
						<li><a href="#categories"><?php esc_html_e('Categories', 'conifer-theme-2'); ?></a></li>
						<li><a href="#deals"><?php esc_html_e('Deals', 'conifer-theme-2'); ?></a></li>
						<li><a href="#about"><?php esc_html_e('About Us', 'conifer-theme-2'); ?></a></li>
					</ul>
				</div>
				
				<div class="footer-section">
					<h4><?php esc_html_e('Customer Service', 'conifer-theme-2'); ?></h4>
					<ul>
						<li><a href="#"><?php esc_html_e('Contact Us', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Shipping Info', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Returns', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('FAQ', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Size Guide', 'conifer-theme-2'); ?></a></li>
					</ul>
				</div>
				
				<div class="footer-section">
					<h4><?php esc_html_e('My Account', 'conifer-theme-2'); ?></h4>
					<ul>
						<li><a href="#"><?php esc_html_e('My Account', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Order History', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Wishlist', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Newsletter', 'conifer-theme-2'); ?></a></li>
						<li><a href="#"><?php esc_html_e('Specials', 'conifer-theme-2'); ?></a></li>
					</ul>
				</div>
				
				<div class="footer-section">
					<h4><?php esc_html_e('Contact Info', 'conifer-theme-2'); ?></h4>
					<div class="contact-info">
						<p><i class="fas fa-map-marker-alt"></i> 41 Nguyen Hue, Hue City, Vietnam</p>
						<p><i class="fas fa-phone"></i> +84 905 567 890</p>
						<p><i class="fas fa-envelope"></i> info@prestashop.com</p>
						<p><i class="fas fa-clock"></i> Mon - Fri: 9:00 AM - 6:00 PM</p>
					</div>
				</div>
			</div>
			
			<div class="footer-bottom">
				<p>&copy; <?php echo esc_html( date('Y') ); ?> PrestaShop. All rights reserved.</p>
				<div class="payment-methods">
					<i class="fab fa-cc-visa"></i>
					<i class="fab fa-cc-mastercard"></i>
					<i class="fab fa-cc-paypal"></i>
					<i class="fab fa-cc-amex"></i>
					<i class="fab fa-cc-discover"></i>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>


