<?php
if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();

$videos = pcdm_get_video_archive();
$video_key = 1;
?>

<section class="wrap-video">
  <?php if (count($videos)): ?>
    <ul class="video-list">
      <?php foreach ($videos as $video): ?>
        <li class="item-video">
          <article>
            <div class="text">
              <h1 class="title"><?php echo $video['post_title'] ?></h1>
              <p class="description">
                <?php echo $video[PcdmVideo::TYPE_PREFIX . 'description']; ?>
              </p>
              <div class="wrap-more">
                <a href="#" class="more"><?php echo _e('play-video') ?></a>
              </div>
            </div>
            <div class="wrap-video">
              <?php if (isset($video[PcdmVideo::TYPE_PREFIX . 'video_link'])): ?>
                <iframe id="vimeoplayer_<?php echo $video_key; ?>" class="js-vimeo video" src="http://player.vimeo.com/video/<?php echo $video[PcdmVideo::TYPE_PREFIX . 'video_link'] ?>?api=1&player_id=vimeoplayer_<?php echo $video_key; ?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
              <?php endif; ?>
              <a class="close">X</a>
              <a class="link-video" href="#">
                <span class="ico-video"></span>
                <?php if (isset($video[PcdmVideo::TYPE_PREFIX . 'wall_image_id'])): ?>
                  <?php $img = wp_get_attachment_image_src($video[PcdmVideo::TYPE_PREFIX . 'wall_image_id'], PcdmVideo::TYPE_PREFIX . 'wall_image'); ?>
                  <img class="placeholder" src="<?php echo $img[0]; ?>" alt="">
                <?php endif; ?>
              </a>
            </div>
          </article>
        </li>
        <?php $video_key++; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>