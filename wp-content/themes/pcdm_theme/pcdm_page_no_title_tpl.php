<?php
/*
Template Name: Page No Title
*/
get_header();
$page = get_post();
?>

<?php echo $page->post_content;?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
