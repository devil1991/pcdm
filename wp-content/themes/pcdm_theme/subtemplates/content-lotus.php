<?php
  $asset_url = get_stylesheet_directory_uri();
?>
<section class="template-lotus">
  <div class="lotus__header">
    <div class="lotus__header__bottom">
      <img src="<?php echo $asset_url;?>/public/images/basee.jpg" alt="">
      <!-- bottom.png
middle.png
top.png -->
    </div>
    <div class="lotus__header__top">
      <img src="<?php echo $asset_url;?>/public/images/top.png" alt="">
    </div>
    <div class="lotus__callout">
      <div class="wrap">
        <h2><?php the_title();?></h2>
        <p><?php the_field('brief');?></p>
        <!-- <div class="lotus__countdown" id="countdown" data-time="<?php the_field('countdown_time');?>">
          <div class="lotus__countdown__span">
            <div class="time-number" id="days">02</div>
            <div class="time-label">days</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="sep">/</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="time-number" id="hours">02</div>
            <div class="time-label">hours</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="sep">/</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="time-number" id="mins">02</div>
            <div class="time-label">mins</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="sep">/</div>
          </div>
          <div class="lotus__countdown__span">
            <div class="time-number" id="secs">02</div>
            <div class="time-label">secs</div>
          </div>
        </div> -->
        <?php if(get_field('shop_now_link')):?>
          <div class="show-now-btn">
            <a href="<?php the_field('shop_now_link');?>" class="btn btn--orange"><span>shop now</span></a>
          </div>
        <?php endif;?>
        <div class="lotus__scrolldown">
          <div class="scrolldown__text">scroll down to discover more</div>
          <div class="scrolldown__svg">
            <svg enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#ffffff" d="M14.77,23.795L5.185,14.21c-0.879-0.879-0.879-2.317,0-3.195l0.8-0.801c0.877-0.878,2.316-0.878,3.194,0  l7.315,7.315l7.316-7.315c0.878-0.878,2.317-0.878,3.194,0l0.8,0.801c0.879,0.878,0.879,2.316,0,3.195l-9.587,9.585  c-0.471,0.472-1.104,0.682-1.723,0.647C15.875,24.477,15.243,24.267,14.77,23.795z" fill="#515151"/></svg>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="lotus__canvas--item lotus__canvas--top lotus__canvas--bottom">
      <img class="touchonly" src="<?php echo $asset_url; ?>/public/images/video-top.jpg" alt="">
      <video class="desktoponly" loop autoplay poster="<?php echo $asset_url; ?>/public/images/Video-bottom.jpg">
        <source src="<?php echo $asset_url; ?>/public/images/video-bottom.mp4"></source>
        <source src="<?php echo $asset_url; ?>/public/images/video-bottom.webmhd.webm"></source>
        <source src="<?php echo $asset_url; ?>/public/images/video-bottom.oggtheora.ogv"></source>
      </video>
    </div> -->
  </div>

  <div class="lotus__top-frame">
    <img src="<?php echo $asset_url; ?>/public/images/lptus-top-rotate.png" alt="">
  </div>

  <div class="lotus__shoes">
    <div class="lotus__shoe-parrot left">
      <img src="<?php echo $asset_url; ?>/public/images/lotus-left.gif" alt="">
    </div>
    <div class="lotus__shoe-parrot right">
      <img src="<?php echo $asset_url; ?>/public/images/lotus-right.gif" alt="">
    </div>
    <div class="lotus__shoes__slider flexslider">
      <ul class="lotus__shoes__wrap slides">
        <?php if( have_rows('sandal_images') ):
          while ( have_rows('sandal_images') ) : the_row();
        ?>
          <li class="lotus__shoe">
            <div class="lotus__shoe__image">
              <img src="<?php the_sub_field('image');?>" alt="">
            </div>
          </li>
        <?php endwhile;?>
      <?php endif;?>
      </ul>
    </div>
  </div>

  <div class="lotus__top-frame">
    <img src="<?php echo $asset_url; ?>/public/images/lptus-top.png" alt="">
  </div>

  <!-- <div class="wall-wrap">
    <div class="wall__row">
      <div class="wall__brick w50 h100 pt pl">
        <div class="lotus__image-text__image lower-flexslider flexslider">
          <ul class="lotus__image-text__image-wrap slides">
            <?php //if( have_rows('row_slider') ):
              //while ( have_rows('row_slider') ) : the_row();
            ?>
              <li class="lotus__shoe">
                <img src="<?php //the_sub_field('row_1_slider_image');?>" alt="">
              </li>
            <?php //endwhile;?>
          <?php //endif;?>
          </ul>
        </div>
      </div>
      <div class="wall__brick w50 h100 pt pr lotus__about-brick">
        <div class="wall__brick__text">
          <h3 class="brick-title"><?php //the_field('row1_title');?></h3>
          <p><?php //the_field('row1_text');?></p>
          <div class="show-now-btn">
            <a href="<?php //the_field('shop_now_link');?>" class="btn btn--orange"><span>shop now</span></a>
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <!-- <div class="lotus__image-text">
    <div class="lotus__image-text__image lower-flexslider flexslider">
      <ul class="lotus__image-text__image-wrap slides">
        <?php// if( have_rows('row_slider_2') ):
          //while ( have_rows('row_slider_2') ) : the_row();
        ?>
          <li class="lotus__shoe">
            <img src="<?php //the_sub_field('row_2_slider_image');?>" alt="">
          </li>
        <?php //endwhile;?>
      <?php //endif;?>
      </ul>
    </div>
    <div class="lotus__image-text__text">
      <div class="wall__brick__text">
        <h3 class="brick-title"><?php //the_field('row2_title');?></h3>
        <p><?php //the_field('row2_text_block');?></p>
      </div>
    </div>
  </div> -->
  <div class="lotus__top-frame">
    <img src="<?php echo $asset_url; ?>/public/images/lotus-bottom.jpg" alt="">
  </div>





</section>