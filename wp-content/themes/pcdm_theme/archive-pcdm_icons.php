<?php
if (is_user_logged_in() || !MAINTENANCE)://LOGGED USERS
  get_header();

  $videos = pcdm_get_icons_archive();
  $video_key = 1;
  ?>



  <section class="wrap-icons">
    <?php if (count($videos)): ?>
      <ul class="video-list">
        <?php foreach ($videos as $video): ?>
          <li class="item-video">
            <article>
              <div class="wrap-video">
                <iframe id="vimeoplayer_<?php echo $video_key ?>" class="js-vimeo video" src="http://player.vimeo.com/video/<?php echo $video[PcdmIcons::TYPE_PREFIX . 'video_link'] ?>?api=1&player_id=vimeoplayer_<?php echo $video_key; ?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                <a class="close">X</a>
                <a class="link-video" href="#">
                  <div class="text">
                    <span class="number"><em><?php echo _e('Icon') ?></em> N&deg;<?php echo $video_key ?></span>
                    <h1 class="title"><?php echo $video['post_title'] ?></h1>
                    <div class="wrap-more">
                      <span class="more"><?php echo _e('Watch Movie') ?></span>
                    </div>
                     <span class="ico-video" style=""></span>
                  </div>
                  <?php if (isset($video[PcdmIcons::TYPE_PREFIX . 'wall_image_id'])): ?>
                    <?php $img = wp_get_attachment_image_src($video[PcdmIcons::TYPE_PREFIX . 'wall_image_id'], PcdmIcons::TYPE_PREFIX . 'wall_image'); ?>
                    <img class="placeholder" src="<?php echo $img[0]; ?>" alt="<?php echo pcdm_get_img_alt($video[PcdmIcons::TYPE_PREFIX . 'wall_image_id']); ?>">
                  <?php else: ?>
                    <img class="placeholder" src="<?php echo pcdm_get_theme_resource('images/store-canvas.jpg'); ?>" alt="">
                  <?php endif; ?>
                </a>
              </div>
            </article>
          </li>
          <?php $video_key++; ?>
        <?php endforeach; ?>
    <!--<li><img class="coming-soon" src="<?php echo pcdm_get_theme_resource('images/placeholder/coming-soon.jpg'); ?>" alt=""></li>-->
      </ul>
    <?php endif; ?>
  </section>

  <?php get_sidebar(); ?>
  <?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
  <?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php'); ?>
<?php endif; ?>