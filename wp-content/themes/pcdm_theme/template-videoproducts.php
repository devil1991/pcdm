<?php
/*
Template Name: Video Product Catalog
*/
if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>

<?php get_template_part('subtemplates/content-videoproducts'); ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>
