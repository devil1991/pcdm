<section id="videoproducts" style="opacity: 0">
  <div class="videoproducts__videoWrap">
    <div class="videoproducts__video">
      <iframe id='player' src="https://www.youtube.com/embed/<?php the_field('youtube_id'); ?>?enablejsapi=1&rel=0&playsinline=0"> </iframe>
      <div class="videoproducts__videoCover" style='background-image:url(https://i.ytimg.com/vi/<?php the_field('youtube_id'); ?>/maxresdefault.jpg)'>
        <div class="playIcon">
          <svg width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g>
                  <path d="M15.5615866,8.10002147 L3.87056367,0.225209313 C3.05219207,-0.33727727 2,0.225209313 2,1.12518784 L2,16.8748122 C2,17.7747907 3.05219207,18.3372773 3.87056367,17.7747907 L15.5615866,9.89997853 C16.1461378,9.44998927 16.1461378,8.55001073 15.5615866,8.10002147 L15.5615866,8.10002147 Z"></path>
              </g>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <div class="videoproducts__shop">
    <a href="">
      <?php echo _e('shop the story'); ?>
      <span>&#8595;</span>
    </a>
  </div>

<?php
  $productGrid = array(
    array(
      'kind' => 'big',
      'positions' => array()
    ),
    array(
      'kind' => 'small',
      'positions' => array('second', 'third')
    ),
    array(
      'kind' => 'small',
      'positions' => array('third','fourth')
    ),
    array(
      'kind' => 'big',
      'positions' => array()
    ),
    array(
      'kind' => 'small',
      'positions' => array('second', 'third')
    ),
    array(
      'kind' => 'small',
      'positions' => array('third','fourth')
    ),
    array(
      'kind' => 'big',
      'positions' => array()
    ),
    array(
      'kind' => 'small',
      'positions' => array('fourth')
    ),
    array(
      'kind' => 'small',
      'positions' => array('second', 'third')
    ),
    array(
      'kind' => 'big',
      'positions' => array()
    )
  );
  $products = get_field('products');
  if ($products):
?>

  <div class="videoproducts__grid">


    <section class="wrap-product-grid">
        <div class="product-grid">

          <?php
            $rowCounter = 0;
            $currentGrid = array();
            while (count($products)):
              if (count($currentGrid) == 0) {
                $currentGrid = $productGrid;
              }
              $currentType = array_shift($currentGrid);

          ?>
            <?php if ($rowCounter % 2 == 0):?>
              <div class="line js-last-child">
            <?php endif;?>
              <?php if ($currentType['kind'] == 'big'):?>
                <?php
                  $product = array_shift($products);
                  $productBigImageID = (int) get_post_meta($product->ID, PcdmProduct::TYPE_PREFIX . 'wall_image_id', true);
                  $big_img = wp_get_attachment_image_src($productBigImageID,  PcdmProduct::TYPE_PREFIX .'wall_image_big');
                ?>

                <!-- Big Item -->
                <div class="item big">
                  <a target='_blank' href="<?php the_field('shoppable_link', $product->ID);?>" title="" data-id="<?php echo $product->ID; ?>">
                    <img src="<?php echo $big_img[0]; ?>">
                    <div class="hover white" style="background-color:#ee2677">
                        <div class="text">
                          <span class="number"><?php echo $product->post_title; ?></span>
                            <h1 class="title"><?php echo _e('Shop now on farfetch')?></h1>
                            <div class="wrap-more">
                                <span class="more"><?php echo _e('Shop now on farfetch')?></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              <?php endif;?>

              <?php if ($currentType['kind'] == 'small'):?>
                <?php
                  $smallProducts = array();
                  for ($i = 0; $i < count($currentType['positions']); $i++) {
                    if (count($products)) {
                      $smallProducts[] = array_shift($products);
                    }
                  }
                ?>
                <?php if (count($smallProducts)):?><div class="item small"><img class="place-holder" src="<?php echo pcdm_get_theme_resource('images/placeholder-empty.gif') ?>" alt=""><div class="line js-last-child"><?php endif;?>
                <?php
                  $innerProductIndex = 0;
                  foreach ($smallProducts as $product):
                    $position = $currentType['positions'][$innerProductIndex];
                ?>
                  <?php
                    $productBigImageID = (int) get_post_meta($product->ID, PcdmProduct::TYPE_PREFIX . 'wall_image_id', true);
                    $small_img = wp_get_attachment_image_src($productBigImageID,  PcdmProduct::TYPE_PREFIX .'wall_image_big');
                  ?>

                    <a target='_blank' class="<?php echo $position; ?>" href="<?php the_field('shoppable_link', $product->ID);?>" title="" data-id="<?php echo $product->ID; ?>">
                      <img src="<?php echo $small_img[0]?>">
                      <div class="hover white" style="background-color:#ee2677">
                          <div class="text">
                              <span class="number"><?php echo $product->post_title; ?></span>
                              <h1 class="title"><?php echo _e('Shop now on farfetch')?></h1>
                              <div class="wrap-more">
                                  <span class="more"><?php echo _e('Shop now on farfetch')?></span>
                              </div>
                          </div>
                      </div>
                    </a>


                <?php $innerProductIndex++; endforeach;?>
                <?php if (count($smallProducts)):?></div></div><?php endif;?>
              <?php endif;?>



            <?php if ($rowCounter % 2 != 0):?>
              </div>
            <?php endif;?>

          <?php
            $rowCounter++;
            endwhile;
          ?>



            <!-- MULTIPLE ITEMS -->
            <?php
              // $position = 'first'; second third forth
              // $_bigitem = get_post($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_' . $ll]);
              // $_element = pack_product($_bigitem, get_post_meta($_bigitem->ID));
              // $_notLink = get_field('not_a_link',$_element['ID']);
              // $small_img = wp_get_attachment_image_src($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id'],  PcdmProduct::TYPE_PREFIX .'wall_image_small' );
            ?>





        </div>
    </section>

  </div>

<?php endif;?>

</section>
<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
