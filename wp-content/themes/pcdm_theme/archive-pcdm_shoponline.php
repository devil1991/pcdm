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

$shops = pcdm_get_shoponline_archive();
$firstl = true;
$right = true;
?>

<section class="wrap-shop">
  <!--header vertical menu-->
  <div class="wrap-text js-vertical-fixed-menu">
    <header>
      <span class="number">/5</span>
      <h1 class="title"><?php echo _e('shop <br> online') ?></h1>
      <nav class="nav-social">
        <ul class="js-sharing js-last-child">
          <li class="facebook">
            <a  title="facebook" href="#" target="blank">Facebook</a>
          </li>
          <li class="histagram">
            <a title="histagram" href="#" target="blank">histagram</a>
          </li>
          <li class="twitter">
            <a title="twitter" href="#" target="blank">twitter</a>
          </li>
          <li class="pinterest">
            <a title="pinterest" href="#" target="blank">You Tube</a>
          </li>
          <li class="tumblr">
            <a title="tumblr" href="#" target="blank">tumblr</a>
          </li>
        </ul>
      </nav>
    </header>
    <p class="description">
      <?php echo _e('Shop online at WW luxury boutiques. Choose your favourite online retailer to find Paula Cademartori latest collections.') ?>
    </p>
    <?php if (count($shops)): ?>
      <nav class="shop-nav">
        <h3 class="label-title">
          <?php echo _e('Select a letter') ?>
        </h3>
        <ul class="js-vertical-fixed-menu-items">
          <?php foreach ($shops as $letter => $shop): ?>
            <li><a <?php if ($firstl): ?>class="current" <?php endif; ?>href="#<?php echo $letter ?>" title="<?php echo $letter ?>"><?php echo strtoupper($letter) ?></a></li>
            <?php $firstl = false ?>
          <?php endforeach; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
  <!--end header vertical menu-->

  <!--start shops-->
  <?php if (count($shops)): ?>
    <div class="wrap-shop-list js-vertical-fixed-menu-sections">
      <?php foreach ($shops as $letter => $shop)://$right = true; ?>
        <div class="shop-list" id="<?php echo $letter ?>">
          <span class="letter"><?php echo strtoupper($letter) ?></span>
          <ul>
            <?php foreach ($shop as $shoponline): ?>
              <li class="shop <?php if ($right): ?>right<?php else: ?>left<?php endif; ?>">
                <article>
                  <h2 class="name"><?php echo $shoponline['post_title'] ?></h2>
                  <?php if (isset($shoponline[PcdmShoponline::TYPE_PREFIX . 'link'])): ?>
                    <span class="link-label"><?php echo $shoponline[PcdmShoponline::TYPE_PREFIX . 'textlink']; ?></span>
                  <?php endif; ?>
                  <?php if (isset($shoponline[PcdmShoponline::TYPE_PREFIX . 'description'])): ?>
                    <p class="description">
                      <?php echo $shoponline[PcdmShoponline::TYPE_PREFIX . 'description']; ?>
                    </p>
                  <?php endif; ?>
                  <?php if (isset($shoponline[PcdmShoponline::TYPE_PREFIX . 'link'])): ?>
                    <a href="<?php echo $shoponline[PcdmShoponline::TYPE_PREFIX . 'link']?>" title="" class="link"><span><?php echo _e('shop now') ?></span></a>
                  <?php endif; ?>
                </article>
                <?php if (isset($shoponline[PcdmShoponline::TYPE_PREFIX . 'wall_image_id'])): ?>
                  <?php $img = wp_get_attachment_image_src($shoponline[PcdmShoponline::TYPE_PREFIX . 'wall_image_id'], PcdmShoponline::TYPE_PREFIX . 'wall_image'); ?>
                  <img class="img-deco" src="<?php echo $img[0] ?>" alt="">
                <?php endif; ?>
              </li>
              <?php $right = !$right; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
<!--end shops-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>