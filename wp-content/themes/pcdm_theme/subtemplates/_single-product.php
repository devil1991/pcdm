<?php
  $product_meta = get_post_meta($product->ID);
  $pruductargs = array(
    'posts_per_page'   => -1,
    'post_type' => PcdmProduct::TYPE_IDENTIFIER,
    'tax_query' => array(
        array(
        'taxonomy' => $season_tax->taxonomy,
        'field' => 'term_id',
        'terms' => $season_tax->term_id
        )
    ),
    'order'     => 'ASC',
    'meta_key' => 'pcdm_pr_number',
    'orderby' => 'meta_value_num'
  );
  $products = get_posts($pruductargs);
  $total_products= count($products);
  $current_index = 0;
  foreach ($products as $temp) {
    if($temp->ID == $product->ID){
      break;
    }
    $current_index++;
  }
  $prev_product = '#';
  $next_product = '#';
  if($current_index != 0){
    $prev = $current_index - 1;
    $prev_product = get_the_permalink($products[$prev]->ID);
  }
  if($current_index+1 != $total_products){
    $next = $current_index + 1;
    $next_product = get_the_permalink($products[$next]->ID);
  }
?>
<article id="single-product-cont" class="single-product" data-callback="wp-admin/admin-ajax.php"  style="background-image:url(<?php echo get_field('single_product_bg',$season_tax); ?>);">
  <div class="single-product-wrap">
    <div class="single-product__wrap-text animated fadeInRightBig">
      <div class="single-product__centering">
        <!-- <a href="#" class="back back-mobile"><?php echo _e('back to the collection')?></a> -->
        <ul class="paginator">
          <li><a class="previous <?php if($current_index == 0){echo 'disabled';}?>" href="<?php echo $prev_product;?>" title=""><i class="fa fa-angle-left"></i></a></li>
          <li><a class="next <?php if($current_index == $total_products-1){echo 'disabled';}?>" href="<?php echo $next_product;?>" title=""><i class="fa fa-angle-right"></i></a></li>
        </ul>
        <header>
          <span class="number">/<?php echo  $product_meta['pcdm_pr_number'][0]; ?></span>
          <span class="collection"><?php echo $season_tax->name;?></span>
          <h1 class="title"><?php the_title();?></h1>
        </header>
        <p class="description">
          <?php  echo $product_meta[PcdmProduct::TYPE_PREFIX . 'description'][0];?>
        </p>
        <nav class="nav-social">
          <h4 class="title-share">share</h4>
          <ul id="collection-details-sharing" class="js-sharing js-last-child">
            <li class="facebook">
              <a  title="facebook" href="#" target="blank"><i class="fa fa-facebook"></i></a>
            </li>
            <li class="twitter">
              <a title="twitter" href="#" target="blank"><i class="fa fa-twitter"></i></a>
            </li>
            <li class="pinterest">
              <a title="pinterest" href="#" target="blank"><i class="fa fa-pinterest"></i></a>
            </li>
            <li class="tumblr">
              <a title="tumblr" href="#" target="blank"><i class="fa fa-tumblr"></i></a>
            </li>
          </ul>
        </nav>
        <a href="<?php echo (get_term_link($season_tax));?>" class="back back-collection"><?php echo _e('back to the collection')?></a>
      </div>
    </div>
    <div class="single-product__image animated fadeInRightBig">
      <img src="<?php echo $product_meta['pcdm_pr_detail_image'][0]?>" alt="">
    </div>
  </div>
</article>
