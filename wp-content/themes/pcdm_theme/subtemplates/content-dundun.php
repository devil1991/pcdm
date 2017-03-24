<section class="template-dundun">

  <div class="dundun__video-canvas" data-0="transform:translateY(0px);opacity:1" data-top-bottom="transform:translateY(500px);opacity:0.8">
    <video id="dundun-video"  autoplay="autoplay" loop poster="<?php the_field('intro_canvas_image');?>">
      <?php if( have_rows('intro_video') ): ?>
        <?php while ( have_rows('intro_video') ) : the_row(); ?>
          <?php $data = get_sub_field('video');?>
          <source src="<?php echo $data['url'];?>"></source>
        <?php endwhile;?>
      <?php endif;?>
    </video>
    <div class="scrolldown">
      <div class="scrolldown__text">Scroll Down</div>
      <div class="scrolldown__svg">
        <svg width="20" height="10">
          <line stroke-width="2px" stroke="#ffffff" x1="0" y1="0" x2="10" y2="10"></line>
          <line stroke-width="2px" stroke="#ffffff" x1="20" y1="0" x2="10" y2="10"></line>
        </svg>
      </div>
    </div>
  </div>
  <div class="dundun__cover-image">
    <img src="<?php the_field('intro_canvas_image');?>" alt="">
  </div>
  <div class="dundun__intro">
    <div class="wrap" data-0="opacity:0" data-120-top="opacity:1">
      <h1 class="dundun__intro-title"><?php the_field('intro-title'); ?></h1>
      <div class="dundun__intro-info"><?php the_field('intro-info'); ?></div>
    </div>
  </div>

  <?php if( have_rows('rows') ): ?>

    <?php while ( have_rows('rows') ) : the_row(); ?>
      <?php $row_type = get_sub_field('row_type'); ?>
        <?php
          if($row_type == 'type1'):
            $rowClasses = ( get_sub_field('is_inverse') == true ) ? 'dundun__row--inverse' : '';
        ?>
          <div class="dundun__row <?php echo $rowClasses; ?>">
            <div class="dundun__row-wrap">
              <div class="dundun__row__item big dundun__row__item--image wow fadeIn ">
                <?php if(get_sub_field('is_3d_gallery')) :?>
                  <div class="rotating-gallery js-rotating-gallary" id="" style="background-color:<?php the_sub_field('3d_gallery_bg');?>">
                    <?php
                      $images = get_sub_field('3d_gallary_images');
                      if($images) :
                        foreach( $images as $image ):
                    ?>
                      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    <?php endforeach; endif;?>
                  </div>
                <?php else: ?>
                  <img src="<?php the_sub_field('big_image'); ?>" alt="">
                <?php endif;?>
              </div>
              <div class="dundun__row__item small dundun__row__item--text-image wow fadeIn">
                <div class="dundun__text-block">
                  <p><?php the_sub_field('text_box'); ?></p>
                  <?php if(get_sub_field('is_3d_gallery')) :?>
                    <span href="#" class="dundun__link">spin the bag</span>
                  <?php endif;?>
                </div>
                <div class="dundun__image-block wow fadeIn">
                  <img src="<?php the_sub_field('small_image'); ?>" alt="">
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="dundun__row dundun__row--type-2">
            <div class="dundun__row-wrap">
              <div class="dundun__row__item small dundun__row__item--image wow fadeIn">
                <img src="<?php the_sub_field('medium_image_1'); ?>" alt="">
              </div>
              <div class="dundun__row__item small dundun__row__item--text-image wow fadeIn">
                <div class="dundun__text-block">
                  <p><?php the_sub_field('text_box'); ?></p>
                </div>
                <div class="dundun__image-block">
                  <img src="<?php the_sub_field('small_image'); ?>" alt="">
                </div>
              </div>
              <div class="dundun__row__item small dundun__row__item--image wow fadeIn">
                 <img src="<?php the_sub_field('medium_image_2'); ?>" alt="">
              </div>
            </div>
          </div>
        <?php endif; ?>
    <?php endwhile; ?>

  <?php else : ?>
  <?php endif; ?>


  <!-- <div class="dundun__row">
    <div class="dundun__row-wrap">
      <div class="dundun__row__item big dundun__row__item--image">
        <img src="http://placehold.it/910x510" alt="">
      </div>
      <div class="dundun__row__item small dundun__row__item--text-image">
        <div class="dundun__text-block">
          <p>It was a Nantucket ship, the BachelorIt was a Nantucket ship, the BachelorIt was a Nantucket ship, the Bachelor</p>
          <span href="#" class="dundun__link">spin the bag</span>
        </div>
        <div class="dundun__image-block">
          <img src="http://placehold.it/456x200" alt="">
        </div>
      </div>
    </div>
  </div>

  <div class="dundun__row dundun__row--inverse">
    <div class="dundun__row-wrap">
      <div class="dundun__row__item big dundun__row__item--image">
        <img src="http://placehold.it/910x510" alt="">
      </div>
      <div class="dundun__row__item small dundun__row__item--text-image">
        <div class="dundun__text-block">
          <p>It was a Nantucket ship, the BachelorIt was a Nantucket ship, the BachelorIt was a Nantucket ship, the Bachelor</p>
          <span href="#" class="dundun__link">spin the bag</span>
        </div>
        <div class="dundun__image-block">
          <img src="http://placehold.it/456x200" alt="">
        </div>
      </div>
    </div>
  </div>
  <img src="http://placehold.it/455x510" alt=""> -->



</section>