<?php
/* Template Name: Home Page */
/* Thin wrapper to render the same content as front-page.php when assigned explicitly */
get_header();
?>

<?php
    // Reuse front-page sections by including the template parts or duplicating markup minimally
    // Here, simply include the front-page main sections by loading the file
    locate_template('front-page.php', true, false);
?>

<?php get_footer(); ?>


