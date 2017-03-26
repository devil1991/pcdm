<section id="videoproducts">
  <div class="videoproducts__videoWrap">
    <div class="videoproducts__video">
      <div data-type="youtube" data-video-id="JGwWNGJdvx8"></div>
    </div>
  </div>


  <div class="videoproducts__grid">


    <section class="wrap-product-grid">
        <div class="product-grid">

          <div class="line js-last-child">

            <?php
              $_bigitem = get_post($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_a']);
              if ($_bigitem->ID) {
                $_element = pack_product($_bigitem, get_post_meta($_bigitem->ID));
                $_notLink = get_field('not_a_link',$_element['ID']);
                $big_img = wp_get_attachment_image_src($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id'],  PcdmProduct::TYPE_PREFIX .'wall_image_big' );
              }
            ?>
            <!-- Big Item -->
            <div class="item big">
              <a href="#" title="" data-id="<?php echo $_element['ID'] ?>">
                <img src="<?php echo $big_img[0] ?>" alt="<?php echo pcdm_get_img_alt($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id']);?>">
                <div class="hover white" style="background-color:#ee2677">
                    <div class="text">
                        <span class="number">/<?php echo $_element[PcdmProduct::TYPE_PREFIX . 'number'] ?></span>
                        <h1 class="title"><?php echo $_element['post_title'] ?></h1>
                        <div class="wrap-more">
                            <span class="more"><?php echo _e('More')?></span>
                        </div>
                    </div>
                </div>
              </a>
            </div>


            <!-- MULTIPLE ITEMS -->
            <?php
              // $position = 'first'; second third forth
              // $_bigitem = get_post($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_' . $ll]);
              // $_element = pack_product($_bigitem, get_post_meta($_bigitem->ID));
              // $_notLink = get_field('not_a_link',$_element['ID']);
              // $small_img = wp_get_attachment_image_src($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id'],  PcdmProduct::TYPE_PREFIX .'wall_image_small' );
            ?>
            <div class="item small">
              <img class="place-holder" src="<?php echo pcdm_get_theme_resource('images/placeholder-empty.gif') ?>" alt="">
              <div class="line js-last-child">
                <a class="<?php echo $position; ?>" href="#" title="" data-id="<?php echo $_element['ID'] ?>">
                  <img src="<?php echo $small_img[0]?>" alt="<?php echo pcdm_get_img_alt($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id']);?>">
                  <div class="hover white" style="background-color:#ee2677">
                      <div class="text">
                          <span class="number">/<?php echo $_element[PcdmProduct::TYPE_PREFIX . 'number'] ?></span>
                          <h1 class="title"><?php echo $_element['post_title'] ?></h1>
                          <div class="wrap-more">
                              <span class="more"><?php echo _e('More')?></span>
                          </div>
                      </div>
                  </div>
                </a>
              </div>
            </div>



          </div>

        </div>
    </section>



  </div>

</section>
