<div id="ajaxed-wrap">
  <?php
  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */

  global $is_single;
  global $season_tax;
  // global $_buckets;
  global $term_descriptions;
  global $_product_id;
  global $_data_category;
  $letters = array('first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => 'd');
  // print_r($season_tax);
  // Apply filter


  if ($is_single == 1) {
      global $product;
      include locate_template('/subtemplates/_single-product.php');
  }
  else{
     include locate_template('/subtemplates/_index-products.php');
  }
  ?>
</div>
<section class="products-index__header" id="preloader">
  <div class="products-index__preloader">
      <img src="<?php echo get_field('preloader_image',$season_tax);?>" alt="">
  </div>
</section>
