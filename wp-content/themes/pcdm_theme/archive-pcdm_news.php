<?php
if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>

<section class="hp-news news js-columnist" data-columns="2">
    <div class="news-list">
        <?php foreach (pcdm_get_news_archive() as $news_block): ?>
            <div class="block">
              <?php if(count($news_block['news'])):?>
                <?php foreach ($news_block['news'] as $news): ?>
                    <?php 
                      $news_class = pcdm_get_news_class($news);
                      $img = wp_get_attachment_image_src($news[PcdmNews::TYPE_PREFIX . 'wall_image_id'],PcdmNews::TYPE_PREFIX .'wall_image_'.$news_class );
                    ?>
                    <a class="<?php echo $news_class ?>" href="<?php echo get_permalink( $news['ID'] );?>" title="">
                        <div class="wrap-image">
                            <img src="<?php echo $img[0]?>" alt="<?php echo pcdm_get_img_alt($news[PcdmNews::TYPE_PREFIX . 'wall_image_id']);?>">
                            <div class="hover dark" style="background-color:<?php echo $news[PcdmNews::TYPE_PREFIX . 'hover_color']; ?>"><div class="more"></div></div>
                        </div>
                        <div class="text">
                            <p class="date">
                                <span class="yy"><?php echo date('Y',strtotime($news['post_date']))?>.</span><span class="mm-dd"><?php echo date('m',strtotime($news['post_date']))?>/<?php echo date('d',strtotime($news['post_date']))?></span>
                            </p>
                            <h1 class="title"><?php echo $news['post_title'] ?></h1>
                            <p class="description">
                                <?php echo $news[PcdmNews::TYPE_PREFIX . 'abstract']; ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
              <?php endif;?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
 <?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>