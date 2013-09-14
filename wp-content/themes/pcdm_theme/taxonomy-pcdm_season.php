<?php

if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>

<?php

//recupero la stagione da visualizzare
$queried_object = get_queried_object();
$term_descriptions = explode(",", $queried_object->description);
//effettuo la query
$_buckets = pcdm_get_product_buckets(PcdmSeason::CATEGORY_IDENTIFIER, array($queried_object->slug));
$_data_category = pll_current_language() . rtrim(str_replace(get_bloginfo('url'), "", get_term_link($queried_object->slug, $queried_object->taxonomy)), "/");
$_product_id = mysql_real_escape_string($_GET['pid']);
//carico il template della collezione
load_template(dirname(__FILE__) . '/subtemplates/season-details.php');
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>