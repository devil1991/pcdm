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
          <p class="description"><?php echo _e('Sign up for email updates on latest collections, events and exclusive contents')?></p>
          <a href="#" class="subscribe"><span><?php echo _e('subscribe')?></span></a>
        </li>
        <li>
          <h3 class="title"><?php echo _e('Store list')?></h3>
          <p class="description"><?php echo _e("Find the nearest point of sale for Paula Cademartori's collections")?></p>
          <a class="more" href="<?php echo get_post_type_archive_link(PcdmStore::TYPE_IDENTIFIER )?>" title=""><?php echo _e('go to store list')?></a>
        </li>

        <li class="contacts">
          <h3 class="title"><?php echo _e('Contact Us')?></h3>
          <p class="description">
            <?php echo _e('Email us for general info or press inquiries')?>
          </p>
          <?php
            $_contact_page = get_page_by_title("Contacts" );
            $_contact_page_tr = get_page( pll_get_post($_contact_page->ID, pll_current_language()) );
          ?>
          <a class="more" href="<?php echo get_page_link($_contact_page_tr->ID);?>" title=""><?php echo _e('Enter')?></a>
        </li>
	       <li class="press-area">
           <h3 class="title">...........<?php //echo _e('Press Area')?></h3>
           <p class="description partofotb">
             Paula Cademartori is a part of <a style='margin-left: 5px' href="https://www.otb.net/"><img width='32' src="<?php echo get_template_directory_uri();?>/OTB_LOGOsansFond.png" alt=""></a>
          </p>

        </li>
      </ul>
    </nav>
  </div>
  <?php
    global $polylang;
    if (isset($polylang)){
      $languages = $polylang->model->get_languages_list();
    }else{
      $languages = array();
    }

    ?>
  <div class="wrap-credits">
    <div class="footer-socialnav">
      <ul>
        <li class="facebook">
          <a  title="facebook" href="https://www.facebook.com/paulacademartoribrand" target="blank">Facebook</a>
        </li>
        <li class="histagram">
          <a title="instagram" href="http://instagram.com/pcademartori" target="blank">instagram</a>
        </li>
        <li class="twitter">
          <a title="twitter" href="https://twitter.com/PCademartori" target="blank">twitter</a>
        </li>
        <!-- <li class="pinterest"> -->
          <!-- <a title="pinterest" href="http://www.pinterest.com/pcademartori/" target="blank">You Tube</a> -->
        <!-- </li> -->
        <li class="tumblr">
          <a title="tumblr" href="http://paulacademartori.tumblr.com/" target="blank">tumblr</a>
        </li>
      </ul>
    </div>
    <div class="footer-lang-menu">
      <ul>
        <?php foreach($languages as $lang):?>
        <li><a <?php if(pll_current_language() == $lang->slug):?>class="active"<?php endif;?> href="/<?php echo $lang->slug?>" title=""><?php echo $lang->name; ?></a></li>
        <?php endforeach;?>
      </ul>
    </div>
    <p><?php echo _e('&#169; Paula cademartori. - All rights reserved')?></p>

  </div>
</footer><!-- #colophon -->


</div><!-- wrap body -->
</div><!-- aux body simulator -->
</div><!-- body-simulator-->
<?php wp_footer(); ?>

<div class="wrap-overlay">
  <div class="overlay small newsletter "  style="display:none">
    <a href="#" class="close"></a>
    <header class="header-overlay">
      <h3 class="title">/Newsletter</h3>
    </header>
    <div class="feedback">
      <p><?php echo _e('Thank you for registering')?></p>
    </div>
    <form action="" method="get" accept-charset="utf-8" data-send="/wp-admin/admin-ajax.php?action=registernl" data-lang="<?php echo pll_current_language()?>">
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
        <?php echo _e('I accept the')?> <a href="#" title=""><?php echo _e('Privacy Policy')?></a>
        </label>
        <span class="label-error"><?php echo _e('error')?></span>
      </div>
      <div class="campi btn">
        <input type="submit" class="form-btn" name="" value="<?php echo _e('submit')?>">
      </div>
    </form>
  </div>
    <div class="overlay registration" style="display:none">
    <div class="close-newsletter"></div>
    <img class="img-registration" src="<?php echo get_template_directory_uri();?>/public/images/nlimg.jpg" alt="">
    <div class="wrap-text">
      <header class="header-overlay">
        <h3 class="title">don't miss out!</h3>
        <p class="description"><?php echo _e('Be among the first to be updated on news, latest collection and events from Paulacademartori.com.')?></p>
        <p class="description"><?php echo _e('Sign up now!')?></p>
      </header>
      <div class="feedback">
        <p></p>
      </div>
      <form action="" id="register-form" method="get" accept-charset="utf-8" validate data-send="/wp-admin/admin-ajax.php?action=registernl" data-lang="<?php echo pll_current_language()?>">
        <div class="campi">
          <input id="mc-email" for="email" required type="email" value="email@example.com">
          <div class="form-btn">
            <input type="submit" name="" value="">
          </div>
          <span class="label-error">Please enter a valid email</span>
        </div>
        <!-- EN
          //paulacademartori.us2.list-manage.com/subscribe/post?u=fc8967c84ef3cb8620ee8f94b&amp;id=1c44c3f947
          IT
          //paulacademartori.us2.list-manage.com/subscribe/post?u=fc8967c84ef3cb8620ee8f94b&amp;id=0329e0ad2e
         -->
        <!-- <div class="campi privacy">
          <label>
          <input type="checkbox" name="privacy" value="" class="js-required">
            <?php echo _e('I accept the')?> <a href="#" title="" class="js-open-popup" data-url="/popup_privacy/popup_privacy<?php echo pll_current_language()=='en'?'_en':''?>.html" data-width="400" data-height="300"><?php echo _e('Privacy Policy')?></a>
          </label>
          <span class="label-error">error</span>
        </div> -->
      </form>
    </div>
  </div>
</div>


<script src="http://a.vimeocdn.com/js/froogaloop2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/easing.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.background.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.history.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.mousewheel.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.touchSwipe-1.2.5.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery-migrate-1.2.1.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
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
<script src="<?php echo pcdm_get_theme_resource('scripts/cookie_manager.js'); ?>" type="text/javascript" charset="utf-8"></script>
<!-- <script src="<?php echo pcdm_get_theme_resource('scripts/header_menu.js'); ?>" type="text/javascript" charset="utf-8"></script> -->
<script src="<?php echo pcdm_get_theme_resource('scripts/filter_dropdown.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/filtered_grid.js'); ?>" type="text/javascript" charset="utf-8"></script>
<!-- <script src="<?php echo pcdm_get_theme_resource('scripts/mobile_menu.js'); ?>" type="text/javascript" charset="utf-8"></script> -->
<script src="<?php echo pcdm_get_theme_resource('scripts/newsletter.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/rails_shifter.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/social_sharing.js'); ?>" type="text/javascript" charset="utf-8"></script>
<!-- <script src="<?php echo pcdm_get_theme_resource('scripts/vertical_fixed_menu.js'); ?>" type="text/javascript" charset="utf-8"></script> -->

<script src="<?php echo pcdm_get_theme_resource('scripts/video_manager.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/vimeo_player.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/wow.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/skrollr.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.countdown.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/main.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/dundun.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.flexslider-min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/pagelotus.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/velocity.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.ba-throttle-debounce.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/iscroll.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/lib/jquery.ajaxchimp.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/mainmenu.js'); ?>" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo pcdm_get_theme_resource('scripts/lib/cookie-monster.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo pcdm_get_theme_resource('scripts/pagenews.js'); ?>" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/node_modules/babel-polyfill/dist/polyfill.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/node_modules/plyr/dist/plyr.css">
<script src="<?php echo get_template_directory_uri(); ?>/node_modules/plyr/dist/plyr.js" type="text/javascript" charset="utf-8"></script>


<script src="<?php echo pcdm_get_theme_resource('scripts/v2.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-45018608-1', 'paulacademartori.com');

  ga('send', 'pageview');



</script>

<script type="text/javascript">
  jQuery(document).on('click', '.more.shownow', function(event) {
    event.stopPropagation();
    event.preventDefault();
    var href = $(event.currentTarget).attr('href');
    if (!href) return;
    window.open(href, '_blank')
  })
</script>


</body>
</html>
