<?php

/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>

<?php

$product = get_post();
$_product_id = $product->ID;
$season_tax_obj = array_pop(get_the_terms($_product_id,  PcdmSeason::CATEGORY_IDENTIFIER));
$_data_category = pll_current_language() . rtrim(str_replace(get_bloginfo('url'), "", get_term_link($season_tax_obj->slug, $season_tax_obj->taxonomy)), "/");
$term_descriptions = explode(",",$season_tax_obj->description);
//effettuo la query
$_buckets = pcdm_get_product_buckets(PcdmSeason::CATEGORY_IDENTIFIER, array($season_tax_obj->slug));
//echo "pippo!!1 {$_product_id}";
//carico il template della collezione
load_template(dirname(__FILE__) . '/subtemplates/season-details.php');

?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>