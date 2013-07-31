<?php


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
                <img class="box-img" src="<?php echo $img[0];?>" alt="">
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