<?php

if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header(); ?>

<!--HERE IT COMES!-->
<?php if(is_front_page()): ?>
<section class="box-hp">
<?php foreach(pcdm_get_hp_elements() as $hp_element):?>
    <div class="line js-even-children js-last-child">
         <?php foreach ($hp_element['products'] as $product):?>
         <?php $_class = pcdm_get_home_element_class($product);?>
         <?php $img = wp_get_attachment_image_src($product[PcdmHomeElement::TYPE_PREFIX . 'home_image_id'],PcdmHomeElement::TYPE_PREFIX .'home_image_'.$_class );?>
        <article class="box <?php echo $_class; ?><?php if($product[PcdmHomeElement::TYPE_PREFIX . 'align_left']=='on'):?> dx<?php endif;?>">

            <a href="<?php echo pcdm_get_home_link($product)?>" title="">
                <img class="box-img" src="<?php echo $img[0];?>" alt="<?php echo pcdm_get_img_alt($product[PcdmHomeElement::TYPE_PREFIX . 'home_image_id']);?>">
            <div class="wrap-text">
                <header>
                    <span class="number">/<?php echo $product[PcdmHomeElement::TYPE_PREFIX . 'hp_number']?></span>
                    <h1 class="title"><?php echo $product['post_title'] ?></h1>
                </header>
                <p class="description">
                    <?php echo $product[PcdmHomeElement::TYPE_PREFIX . 'description']?>
                </p>
                <div class="wrap-more">
                  <span class="more"><?php echo _e('discover')?></span>
                  <?php
                    if( function_exists('get_field') ):
                      $shoppableLink = get_field('shoppable_link', $product['parent_id']);
                      if (!empty($shoppableLink)):
                  ?>
                    <div class="more shownow" style="color:#e85743;background: url(<?php echo get_template_directory_uri();?>/public/images/arrow-more-orange.png) right center no-repeat" href="<?php echo $shoppableLink;?>"><?php echo _e('shop on farfetch.com')?></div>
                  <?php endif;?>
                <?php endif;?>
                </div>
            </div>
            </a>
        </article>
        <?php if($product[PcdmHomeElement::TYPE_PREFIX . 'void_after']=='on'):?>
        <article  class="box small empty"></article>
        <?php endif;?>

         <?php endforeach;?>
    </div>
<?php endforeach;?>
</section>
<?php endif;?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>
