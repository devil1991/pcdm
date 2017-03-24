<?php

  $parg = array(
    'posts_per_page'   => -1,
    'post_type' => PcdmProduct::TYPE_IDENTIFIER,
    'order'     => 'ASC',
    'meta_key' => 'pcdm_pr_number',
    'orderby' => 'meta_value_num',
    'tax_query' => array(
        array(
        'taxonomy' => $season_tax->taxonomy,
        'field' => 'term_id',
        'terms' => $season_tax->term_id
        )
    ),
  );
  $products = get_posts($parg);
  foreach ($products as $prod) {
    // print_r(get_post_meta($prod->ID));
  }

?>
<script>
    window.onload = function(){
        new WOW().init();
    };
</script>
<section class="product-catalog" style="background-image:url(<?php echo get_field('background_pattern',$season_tax); ?>);">
    <div class="product-catalog-wrap">
      <?php
        $counter = 1;
        foreach ($products as $post):
            setup_postdata( $post );
            $product_meta = get_post_meta(get_the_ID());
      ?>
        <div class="wow fadeInUp product-catalog__item">
            <?php if($counter == 1): ?>
                <div class="product-catalog__item__text">
                    <div class="product__text-center">
                        <div class="intro_text">
                            <div class="intro-text__text"><?php echo get_field('intro_text',$season_tax); ?></div>
                            <a href="#" class="intro-text__link" data-vimeo-overlay="<?php echo get_field('vimeo_link',$season_tax); ?>"><span><?php echo pll__('Watch the Video')?></span></a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <a href="<?php the_permalink();  ?>" class="<?php if($counter % 2 == 0){echo "even-item";}?> product-catalog__wrap">
                <?php the_post_thumbnail();  ?>
                <img src="<?php echo $product_meta['pcdm_pr_detail_image'][0]?>" alt="">
                <img class="product-image__hover" src="<?php echo $product_meta['pcdm_pr_wall_image'][0];?>" alt="">
            </a>
        </div>
      <?php $counter++; endforeach;?>
    </div>
</section>
<section id="video-container">
    <div class="video-container__close"><span><i class="fa fa-times"></i></span></div>
    <div class="video-container__inner">

    </div>
</section>