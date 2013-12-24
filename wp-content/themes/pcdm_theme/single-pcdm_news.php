<?php
if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>

<?php
$news = get_post();
$_news_details = array_merge((array) $news, get_post_meta($news->ID));

$_detail_image = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'detail_image_id'][0], PcdmNews::TYPE_PREFIX . 'detail_image');
$_slide_1 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_1_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_1');
$_slide_2 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_2_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_2');
$_slide_3 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_3_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_3');
$_slide_4 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_4_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_4');
$_slide_5 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_5_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_5');
$_slide_6 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_6_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_6');
$_slide_7 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_7_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_7');
$_slide_8 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_8_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_8');
$_slide_9 = wp_get_attachment_image_src($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_9_id'][0], PcdmNews::TYPE_PREFIX . 'slide_image_9');
?>

<section class="news-detail news" data-columns="2">
  <article class="big" href="" title="">
    <?php if ($_slide_1 || $_slide_2 || $_slide_3|| $_slide_4|| $_slide_5|| $_slide_6|| $_slide_7|| $_slide_8|| $_slide_9): ?>
      <div class="wrap-carousel js-autoplay js-swipe">
        <ul class="carousel">
          <li class="item"><a href="" title=""><img src="<?php echo $_detail_image[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'detail_image_id'][0]);?>"></a></li>
          <?php if ($_slide_1): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_1[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_1_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_2): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_2[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_2_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_3): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_3[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_3_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_4): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_4[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_4_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_5): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_5[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_5_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_6): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_6[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_6_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_7): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_7[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_7_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_8): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_8[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_8_id'][0]);?>"></a></li>
          <?php endif; ?>
          <?php if ($_slide_9): ?>
            <li class="item"><a href="" title=""><img src="<?php echo $_slide_9[0] ?>" alt="<?php echo pcdm_get_img_alt($_news_details[PcdmNews::TYPE_PREFIX . 'slide_image_9_id'][0]);?>"></a></li>
          <?php endif; ?>
        </ul>
        <ul class="counter js-counter">
          <li>
            <a href="#" class="active">1</a>
          </li>
          <?php if ($_slide_1): ?>
            <li>
              <a href="#">2</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_2): ?>
            <li>
              <a href="#">3</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_3): ?>
            <li>
              <a href="#">4</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_4): ?>
            <li>
              <a href="#">5</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_5): ?>
            <li>
              <a href="#">6</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_6): ?>
            <li>
              <a href="#">7</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_7): ?>
            <li>
              <a href="#">8</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_8): ?>
            <li>
              <a href="#">9</a>
            </li>
          <?php endif; ?>
          <?php if ($_slide_9): ?>
            <li>
              <a href="#">10</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    <?php else: ?>
      <div class="wrap-image">
        <img src="<?php echo $_detail_image[0] ?>" alt="">
      </div>
    <?php endif; ?>
    <div class="text">
      <p class="date">
        <span class="yy"><?php echo date('Y', strtotime($_news_details['post_date'])) ?>.</span><span class="mm-dd"><?php echo date('m', strtotime($_news_details['post_date'])) ?>/<?php echo date('d', strtotime($_news_details['post_date'])) ?></span>
      </p>
      <h1 class="title"><?php echo $_news_details['post_title'] ?></h1>
      <nav class="nav-social">
        <ul class="js-sharing">
          <li class="facebook">
            <a  title="facebook" href="#" target="blank"></a>
          </li>
          <li class="twitter">
            <a title="twitter" href="#" target="blank"></a>
          </li>
          <li class="pinterest">
            <a title="pinterest" href="#" target="blank"> </a>
          </li>
          <li class="tumblr">
            <a title="tumblr" href="#" target="blank"> </a>
          </li>
        </ul>
      </nav>
      <p class="description"><?php echo $_news_details['post_content'] ?>
      </p>
    </div>
  </article>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>