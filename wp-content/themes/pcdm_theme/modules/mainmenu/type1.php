<div class="main-menu__item__sub main-menu__item__sub-four-col">
  <div class="main-menu__sub__inner row">
    <div class="main-menu__back">
      <span class="icon">
        <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon fill="#ffffff" points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 "/></svg>
      </span>
      <span class="label">back</span>
    </div>
    <div class="main-menu__sub-block main-menu__image-block col-4 hoverImage">
      <img src="http://placehold.it/350x250" alt="">
    </div>
    <?php if( have_rows('type1_menu') ): ?>
      <div class="main-menu__type col-8">
        <div class="row">
          <?php while ( have_rows('type1_menu') ) : the_row(); ?>
            <div class="main-menu__sub-block main-menu__links-block col-4">
              <div class="links-block__header">
                <div class="links-block__id">
                  <span>0<?php echo $counter++; ?></span>
                </div>
                <div class="links-block__title">
                  <?php the_sub_field('link_block_title'); ?>
                </div>
              </div>
              <?php if( have_rows('links') ): ?>
                <div class="links-block__links">
                <?php while ( have_rows('links') ) : the_row(); ?>
                  <?php include(locate_template('modules/mainmenu/link-block.php'));?>
                <?php endwhile; ?>
                </div>
              <?php endif;?>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    <?php endif;?>
  </div>
</div>