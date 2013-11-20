<?php
if (is_user_logged_in() || ! MAINTENANCE)://LOGGED USERS
get_header();
?>


<section class="wrap-store">
  <img class="canvas-img" src="<?php echo pcdm_get_theme_resource('images/store-canvas.jpg'); ?>" alt="">
  <section class="store-list">
    <header class="header-storeList">
      <span class="number">/5</span>
      <h1 class="title">store list</h1>
    </header>
    <article class="">

      <?php foreach (pcdm_get_store_archive() as $continent => $continent_data): ?>
        <div class="wrap-continent">
          <h1 class="continent"><?php echo $continent ?></h1>
          <ul class="accordion first-level">
            <?php foreach ($continent_data as $nation => $store_data): ?>
              <li class="item-accordion ">
                <div class="aux-item-accordion">
                  <h2 class="open-accordion">
                    <a class="country" href="#"><?php echo $nation;?><span class="arrow"></span></a></h2>
                  <div class="content-accordion">
                    <nav class="wrap-item second-level">
                      <ul class="wrap-item second-level js-fourth-children">
                        <?php foreach ($store_data as $store): ?>
                          <li class="item">
                            <p>
                              <span class="name"><?php echo $store['post_title'] ;?></span>
                              <span class="address"><?php echo $store[PcdmStore::TYPE_PREFIX."address"] ;?></span>
                              <span class="cap-city"><?php echo $store[PcdmStore::TYPE_PREFIX."cap"] ;?></span>
                              <span class="phone"><?php echo $store[PcdmStore::TYPE_PREFIX."phone"] ;?></span>
                            </p>
                            <a href="<?php echo pcdm_get_map_link($store[PcdmStore::TYPE_PREFIX."coords"]) ? pcdm_get_map_link($store[PcdmStore::TYPE_PREFIX."coords"]) : "#"?>" target="_blank" class="view-map"><?php echo _e('view map')?></a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </nav>
                  </div>
                </div>

              <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </article>
  </section>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else://NOT LOGGED USERS?>
<?php load_template(dirname(__FILE__) . '/subtemplates/maintenance.php');?>
<?php endif;?>