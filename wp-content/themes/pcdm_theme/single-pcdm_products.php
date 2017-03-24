<?php

if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>

<?php
$is_single = 1;
$product = get_post();
$_product_id = $product->ID;
$terms = get_the_terms($_product_id,  PcdmSeason::CATEGORY_IDENTIFIER);
$season_tax = $season_tax_obj = array();
if (count($terms) && $terms !== false) {
  $season_tax = $season_tax_obj = array_pop($terms);
}
$_data_category = pll_current_language() . rtrim(str_replace(get_bloginfo('url'), "", get_term_link($season_tax_obj->slug, $season_tax_obj->taxonomy)), "/");
$term_descriptions = explode(",",$season_tax_obj->description);
//effettuo la query
$_buckets = pcdm_get_product_buckets(PcdmSeason::CATEGORY_IDENTIFIER, array($season_tax_obj->slug));
//echo "pippo!!1 {$_product_id}";
//carico il template della collezione
if(get_field('fixed_scroll_layout',$season_tax)){
  load_template(dirname(__FILE__) . '/subtemplates/content-clutches.php');
}
else{
  load_template(dirname(__FILE__) . '/subtemplates/season-details.php');
}


?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>
