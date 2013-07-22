<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $_buckets;
global $term_descriptions;
global $_product_id;
global $_data_category;
//creo un array per poter scorrere tra i prodotti del bucket
$letters = array('first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => 'd');
?>
<section class="wrap-product-grid" data-category="<?php echo $_data_category?>" data-init-id="<?php if(isset($_product_id)&&!is_null($_product_id)):echo $_product_id; endif;?>">
    <header class="wrap-text header-product-grid">
        <?php if(isset($term_descriptions[0])):?><span class="number"><?php echo $term_descriptions[0]?></span><?php endif;?>
        <?php if(isset($term_descriptions[1])):?><h1 class="title"><?php echo $term_descriptions[1]?></h1><?php endif;?>
        <div class="wrap-more">
            <span class="scroll"><?php echo _e('scroll down')?></span>
        </div>
    </header>

    <div class="product-grid"> 
        <?php
        $c = 2;
        foreach ($_buckets as $bucket):
            ?>

            <?php if ($c % 2 == 0): ?><div class="line js-last-child"><?php endif; ?>
            <?php
            switch ($bucket['pcdm_pb_collection_template']):
                case PcdmProductBucket::TPL_SINGLE:
                    $_bigitem = get_post($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_a']);
                    if ($_bigitem->ID):
                        $_element = pack_product($_bigitem, get_post_meta($_bigitem->ID));
                        $big_img = wp_get_attachment_image_src($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id'],  PcdmProduct::TYPE_PREFIX .'wall_image_big' );
                        ?>
                            <div class="item big">
                                <a href="#" title="" data-id="<?php echo $_element['ID'] ?>">
                                    <img src="<?php echo $big_img[0] ?>" alt="">
                                    <div class="hover <?php if($_element[PcdmProduct::TYPE_PREFIX . 'text_color']=='on'):?> white<?php else:?> dark<?php endif;?>" style="background-color:<?php echo $_element[PcdmProduct::TYPE_PREFIX . 'collection_color'] ?>">
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
                            <?php
                        endif;
                        break;
                    case PcdmProductBucket::TPL_MULTIPLE:
                        ?>

                        <div class="item small">
                            <img class="place-holder" src="<?php echo pcdm_get_theme_resource('images/placeholder-empty.gif') ?>" alt="">
                            <?php
                            $cc = 0;
                            foreach ($letters as $position => $ll):
                                if ($cc % 2 == 0):
                                    ?><div class="line js-last-child"><?php
                                endif;
                                
                                if (!is_null($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_' . $ll]) && $bucket[PcdmProductBucket::TYPE_PREFIX.'prod_' . $ll]!=PcdmProductBucket::VOID_PRODUCT):
                                    $_bigitem = get_post($bucket[PcdmProductBucket::TYPE_PREFIX.'prod_' . $ll]);
                                    $_element = pack_product($_bigitem, get_post_meta($_bigitem->ID));
                                    $small_img = wp_get_attachment_image_src($_element[PcdmProduct::TYPE_PREFIX . 'wall_image_id'],  PcdmProduct::TYPE_PREFIX .'wall_image_small' );
                                    ?>

                                        <a class="<?php echo $position; ?>" href="#" title="" data-id="<?php echo $_element['ID'] ?>">
                                            <img src="<?php echo $small_img[0]?>" alt="">
                                            <div class="hover <?php if($_element[PcdmProduct::TYPE_PREFIX . 'text_color']=='on'):?> white<?php else:?> dark<?php endif;?>" style="background-color:<?php echo $_element[PcdmProduct::TYPE_PREFIX . 'collection_color'] ?>">
                                                <div class="text">
                                                    <span class="number">/<?php echo $_element[PcdmProduct::TYPE_PREFIX . 'number'] ?></span>
                                                    <h1 class="title"><?php echo $_element['post_title'] ?></h1>
                                                    <div class="wrap-more">
                                                        <span class="more"><?php echo _e('More')?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php else:
                                        ?>
                                        <div class="empty <?php echo $position ?>" href="" title="">
                                            <img src="<?php echo pcdm_get_theme_resource('images/placeholder-empty.gif') ?>" alt="">
                                        </div>
                                    <?php
                                    endif;
                                    if ($cc % 2 != 0):
                                        ?></div><?php
                                endif;
                                $cc++;
                            endforeach;
                            ?>
                        </div>
                        <?php
                        break;
                endswitch;
                ?>

                <?php if ($c % 2 != 0): ?></div><?php endif; ?>    
            <?php
            $c++;
        endforeach;
         if ($c % 2 != 0): ?></div><?php endif; ?>
    </div>
</section>   

<div class="loader"></div>
<article class="product-detail" data-callback="wp-admin/admin-ajax.php" style="display:none">
  <div class="wrap-text">
    <ul class="paginator">
      <li><a class="previous" href="#" title=""><?php echo _e('previous')?></a></li>
      <li><a class="next" href="#" title=""><?php echo _e('next')?></a></li>
    </ul>
    <header>
      <span class="number">
      </span>
      <span class="collection"></span>
      <h1 class="title"></h1>
    </header>
    <p class="description"></p>
    <nav class="nav-social">
      <h4 class="title-share">share</h4>
      <ul id="collection-details-sharing" class="js-sharing js-last-child">
        <li class="facebook">
          <a  title="facebook" href="#" target="blank">Facebook</a>
        </li>
        <li class="histagram">
          <a title="histagram" href="#" target="blank">histagram</a>
        </li>
        <li class="twitter">
          <a title="twitter" href="#" target="blank">twitter</a>
        </li>
        <li class="pinterest">
          <a title="pinterest" href="#" target="blank">You Tube</a>
        </li>
        <li class="tumblr">
          <a title="tumblr" href="#" target="blank">tumblr</a>
        </li>
      </ul>
    </nav>
    <a href="#" class="back"><?php echo _e('back to the collection')?></a>
  </div>
  <img class="img-detail" src="" alt="">
</article>
