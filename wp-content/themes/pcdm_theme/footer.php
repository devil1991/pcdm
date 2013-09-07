<?php
/**
 */
?>
  <a href="#" class="back-to-top"><?php echo _e('back to top')?></a>
	</div><!-- .container -->
       </div><!-- #wrapper -->
        <footer class="footer">
  <div class="aux-footer">
    <nav class="footer-navigation">
      <ul class="js-last-child">
        <li>
          <h3 class="title"><?php echo _e('Stay connected')?></h3>
          <p class="description">Violence to his own person. He had lighted with such enerwn person. He had lighted with such ene</p>
          <a href="#" class="subscribe"><span><?php echo _e('subscribe')?></span></a>
        </li>
        <li>
          <h3 class="title"><?php echo _e('Store list')?></h3>
          <p class="description">Violence to his own person. He had lighted with such enerwn person. He had lighted with such ene</p>
          <a class="more" href="<?php echo get_post_type_archive_link(PcdmStore::TYPE_IDENTIFIER )?>" title=""><?php echo _e('go to store list')?></a>
        </li>
        <li>
          <h3 class="title"><?php echo _e('Press Area')?></h3>
          <p class="description">
            P.V. CADEMARTORI SRL
            Headquarter
            Via Pietro Mascagni, 30
            20122 Milano, Italy
          </p>
          <a class="more" href="<?php echo get_post_type_archive_link(PcdmPress::TYPE_IDENTIFIER )?>" title="">discover more</a>
        </li>
        <li>
          <h3 class="title"><?php echo _e('Contact Us')?></h3>
          <p class="description">
            P.V. CADEMARTORI SRL
            Headquarter
            Via Pietro Mascagni, 30
            20122 Milano, Italy
          </p>
          <?php 
            $_contact_page = get_page_by_title("Contacts" );
            $_contact_page_tr = get_page( pll_get_post($_contact_page->ID, pll_current_language()) );
          ?>
          <a class="more" href="<?php echo get_page_link($_contact_page_tr->ID);?>" title="">email us</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="wrap-credits">
    <p><?php echo _e('&#169; Paula cademartori. - All rights reserved')?></p>
  </div>
</footer><!-- #colophon -->

<div class="wrap-overlay">
  <div class="overlay small newsletter ">
    <a href="#" class="close"></a>
    <header class="header-overlay">
      <h3 class="title">/Newsletter</h3>
    </header>
    <div class="feedback">
      <p><?php echo _e('Thank you for registering')?></p>
    </div>
    <form action="" method="get" accept-charset="utf-8" data-send="/wp-admin/admin-ajax.php?action=registernl">
      <div class="campi">
        <input type="text" name="name" id="name" value="<?php echo _e('Name')?>" class="js-required">
        <span class="label-error"><?php echo _e('error')?></span>
      </div>
      <div class="campi">
        <input type="text" name="surname" id="surname" value="<?php echo _e('Surname')?>" class="js-required">
        <span class="label-error"><?php echo _e('error')?></span>
      </div>
      <div class="campi">
        <input type="text" name="email" id="email" value="<?php echo _e('E-mail')?>" class="js-required">
        <span class="label-error"><?php echo _e('error')?></span>
      </div>
      <div class="campi privacy">
        <label>
        <input type="checkbox" name="privacy" value="" class="js-required">
        I accept the <a href="#" title=""><?php echo _e('Privacy Policy')?></a>
        </label>
        <span class="label-error"><?php echo _e('error')?></span>
      </div>
      <div class="campi btn">
        <input type="submit" class="form-btn" name="" value="submit">
      </div>
    </form>
  </div>
</div>

</div><!-- wrap body -->
</div><!-- aux body simulator -->
</div><!-- body-simulator-->
<?php wp_footer(); ?>

<script src="http://a.vimeocdn.com/js/froogaloop2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/easing.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.background.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.history.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.mousewheel.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.touchSwipe-1.2.5.js'); ?>" type="text/javascript" charset="utf-8"></script>
<!--<script src="<?php echo pcdm_get_theme_resource('scripts/lib/modernizr-2.6.1.js'); ?>" type="text/javascript" charset="utf-8"></script>-->
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/EventEmitter.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/greensock/TweenLite.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/greensock/easing/EasePack.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/greensock/plugins/CSSPlugin.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/greensock/plugins/ScrollToPlugin.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/scroller/Animate.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/scroller/EasyScroller.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/scroller/Raf.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/scroller/Scroller.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/swfobject.js'); ?>" type="text/javascript" charset="utf-8"></script>
<!-- app -->
<script src="<?php echo pcdm_get_theme_resource('scripts/pages.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/accordion.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/back_to_top.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/carousel_full.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/collection.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/collection_details.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/columnist.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/header_menu.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/filter_dropdown.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/filtered_grid.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/mobile_menu.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/newsletter.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/rails_shifter.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/social_sharing.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/vertical_fixed_menu.js'); ?>" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo pcdm_get_theme_resource('scripts/video_manager.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/vimeo_player.js'); ?>" type="text/javascript" charset="utf-8"></script>

</body>
</html>