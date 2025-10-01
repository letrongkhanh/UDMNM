<?php
/**
 * The header template
 *
 * @package Conifer
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="header-main">
        <div class="header-main-content">
            <div class="logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="cactus-icon">
                        <img src="<?php echo CONIFER_THEME_URL; ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>">
                    </div>
                    <div class="logo-text">
                        <h1><?php bloginfo('name'); ?></h1>
                        <p><?php bloginfo('description'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <nav class="nav-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu',
                    'container' => false,
                    'fallback_cb' => 'conifer_fallback_menu',
                ));
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
                    <select class="language-dropdown">
                        <option value="vi">VN</option>
                        <option value="en">EN</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</header>
