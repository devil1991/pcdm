<?php
  $links_block_image = false;
?>
<div class="main-menu__item__sub main-menu__item__sub-four-col">
  <div class="main-menu__sub__inner row">
    <div class="main-menu__back">
      <span class="icon">
        <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon fill="#ffffff" points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 "/></svg>
      </span>
      <span class="label">back</span>
    </div>
    <?php if( have_rows('type2_menu') ): ?>
      <?php while ( have_rows('type2_menu') ) : the_row(); ?>
        <?php if( get_row_layout() == 'link_block' ):?>
          <?php
            if($links_block_image != true):
              $links_block_image = true;
          ?>
            <div class="main-menu__sub-block main-menu__image-block col-4 hoverImage">
              <img src="http://placehold.it/350x250" alt="">
            </div>
          <?php endif;?>
          <!-- Block type links -->
          <div class="main-menu__sub-block main-menu__links-block col-4">
            <div class="links-block__header">
              <div class="links-block__id">
                <span>0<?php echo $counter++; ?></span>
              </div>
              <div class="links-block__title">
                <?php the_sub_field('link_block_title'); ?>
              </div>
            </div>
            <?php if( have_rows('links') ): $count = 0; ?>
              <div class="links-block__links row">
                <?php while ( have_rows('links') ) : the_row(); ?>
                <div class="col-6">
                  <?php include(locate_template('modules/mainmenu/link-block.php'));?>
                </div>
                <?php $count++; endwhile; ?>

              </div>
            <?php endif;?>
          </div>
        <?php endif;?>
        <?php if( get_row_layout() == 'link_image_block' ): ?>
          <!-- Block type image -->
          <a href="<?php the_sub_field('link_href');?>" class="main-menu__sub-block main-menu__image-block col-4">
            <?php echo wp_get_attachment_image(get_sub_field('link_image'), 'menu-thumb2'); ?>
            <div class="image-bg"
                  style="
                        backgroud-image:url(<?php echo wp_get_attachment_image_url(get_sub_field('link_image'), 'menu-thumb2'));?>;
                        backgroud-position:center;
                        backgroud-size:cover;
                  "
            >
            </div>
            <div class="main-menu__image-block__center-text">
              <?php the_sub_field('link_label');?>
            </div>
          </a>
        <?php endif;?>
      <?php endwhile; ?>
    <?php endif;?>
  </div>
</div>