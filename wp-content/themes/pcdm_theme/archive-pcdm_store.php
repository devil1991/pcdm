<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>


<section class="wrap-store">
  <img class="canvas-img" src="<?php echo pcdm_get_theme_resource('images/store-canvas.jpg'); ?>" alt="">
  <section class="store-list">
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
<!--      <div class="wrap-continent">
        <h1 class="continent">Europa</h1>
        <ul class="accordion first-level">
          <li class="item-accordion ">
            <div class="aux-item-accordion">
              <h2 class="open-accordion">
                <a class="country" href="#">Austria<span class="arrow"></span></a></h2>
              <div class="content-accordion">
                <nav class="wrap-item second-level">
                  <ul class="wrap-item second-level js-fourth-children">
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                        <span class="phone">+39 0 9893283928</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                        <span class="phone">+39 0 9893283928</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                        <span class="phone">+39 0 9893283928</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                        <span class="phone">+39 0 9893283928</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-city">20154 Milano</span>
                        <span class="phone">+39 0 9893283928</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>

                  </ul>
                </nav>
              </div>
            </div>
          </li>
          <li class="item-accordion ">
            <div class="aux-item-accordion">
              <h2 class="open-accordion">
                <a class="country" href="#">Italia<span class="arrow"></span></a></h2>
              <div class="content-accordion">
                <ul class="wrap-item second-level js-fourth-children">
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="wrap-continent">
        <h1 class="continent">Europa</h1>
        <ul class="accordion first-level">
          <li class="item-accordion ">
            <div class="aux-item-accordion">
              <h2 class="open-accordion">
                <a class="country" href="#">Austria<span class="arrow"></span></a></h2>
              <div class="content-accordion">
                <nav class="wrap-item second-level">
                  <ul class="wrap-item second-level js-fourth-children">
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>
                    <li class="item">
                      <p>
                        <span class="name">10 CORSO COMO </span>
                        <span class="address">Corso Como 10</span>
                        <span class="cap-sity">20154 Milano</span>
                      </p>
                      <a href="#" class="view-map">view map</a>
                    </li>

                  </ul>
                </nav>
              </div>
            </div>
          </li>
          <li class="item-accordion ">
            <div class="aux-item-accordion">
              <h2 class="open-accordion">
                <a class="country" href="#">Italia<span class="arrow"></span></a></h2>
              <div class="content-accordion">
                <ul class="wrap-item second-level js-fourth-children">
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                  <li class="item">
                    <p>
                      <span class="name">10 CORSO COMO </span>
                      <span class="address">Corso Como 10</span>
                      <span class="cap-sity">20154 Milano</span>
                    </p>
                    <a href="#" class="view-map">view map</a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </div>-->
    </article>
  </section>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>