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

$news = get_post();
$_news_details = array_merge((array) $news, get_post_meta($news->ID));

$_detail_image = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'detail_image_id'][0],PcdmNews::TYPE_PREFIX .'detail_image' );

?>

<section class="news-detail news" data-columns="2">
    <article class="big" href="" title="">
        <div class="wrap-image">
            <img src="<?php echo $_detail_image[0]?>" alt="">
        </div>
        <div class="text">
            <p class="date">
                <span class="yy"><?php echo date('y',strtotime($_news_details['post_date']))?>.</span><span class="mm-dd"><?php echo date('m',strtotime($_news_details['post_date']))?>/<?php echo date('d',strtotime($_news_details['post_date']))?></span>
            </p>
            <h1 class="title"><?php echo $_news_details['post_title'] ?></h1>
            <p class="description"><?php echo $_news_details['post_content'] ?>
            </p>
        </div>
    </article>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>