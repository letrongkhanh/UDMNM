<?php
/* Front Page Template */
get_header();

// Render sections via template part
locate_template('template-parts/home-sections.php', true, false);

get_footer();
?>


