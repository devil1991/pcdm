<?php
global $polylang;
if (isset($polylang)){
  $languages = $polylang->model->get_languages_list();
}else{
  $languages = array();
}

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title><?php echo the_title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="title" content="<?php echo pcdm_get_seo_title(); ?>"/>
        <meta name="description" content="<?php echo pcdm_get_seo_description(); ?>"/>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="<?php echo pcdm_get_theme_resource('scripts/lib/modernizr.custom.77341.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <link href="<?php echo pcdm_get_theme_resource('styles/screen.min.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
        <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <?php wp_head(); ?>
        <?php if(pcdm_get_og_image()):?>
        <meta property="og:image" content="<?php echo pcdm_get_og_image()?>">
        <?php endif;?>
<style>
.contact-info .specific-info span {
	display: block;
}
</style>
    </head>

    <body <?php body_class(); ?> >
      <div id="body-simulator">
      <?php include(locate_template('modules/mainmenu/menu.php')); ?>
      <div class="aux-body-simulator">
        <div class="close-menu"></div>
      <!-- <div id="mobile-sidebar"> -->
        <!-- <div class="aux-mobile-sidebar"> -->
          <!-- <a href="<?php echo get_bloginfo('url')?>" class="logo">Paula Cademartori</a> -->
          <!-- <nav class="navbar">
            <ul class="first-level">
              <li class="dropdown">
                <a class="<?php echo pcdm_is_active('categories') ? 'active' : ''?>" href="#" title=""><?php echo _e('Collections')?></a>
                <div class="wrap-dropdown-menu">
                      <ul class="dropdown-menu">
                          <?php
                            $name = 'The New DUNDUN Couture';
                            $name2 = 'The Lotus Sandal';
                            $pid = 5694;
                            $pid2 = 7290;
                            $cur_lang = pll_current_language();
                            if($cur_lang == 'it'){
                              $name = 'La Nuova DUNDUN Couture';
                              $name2 = 'Lotus';
                              $pid = 5832;
                              $pid2 = 7306;
                            }

                          ?>

                          <li>
                              <a class="" href="<?php echo get_page_link($pid2); ?>" title=""><?php echo $name2;?>
                                  <span class="arrow-left"></span>
                                  <span class="arrow-right"></span>
                              </a>
                          </li>

                          <li>
                              <a class="" href="<?php echo get_page_link($pid); ?>" title=""><?php echo $name;?>
                                  <span class="arrow-left"></span>
                                  <span class="arrow-right"></span>
                              </a>
                          </li>
                          <?php foreach(pcdm_get_season_terms() as $_term):?>
                              <?php if($_term->count):?>
                                  <li>
                                      <a class="active" href="<?php echo get_term_link($_term->slug, PcdmSeason::CATEGORY_IDENTIFIER)?>" title=""><?php echo $_term->name?>
                                          <span class="arrow-left"></span>
                                          <span class="arrow-right"></span>
                                      </a
                                  </li>
                              <?php endif;?>
                          <?php endforeach;?>
                      </ul>
                    </div>
              </li>
              <li>
                <?php
                  $_about_page = get_page_by_title("About" );
                  $_about_page_tr = get_page( pll_get_post($_about_page->ID, pll_current_language()) );
                  ?>
                  <a class="<?php echo pcdm_is_active('About') ? 'active' : ''?>" href="<?php echo get_page_link($_about_page_tr->ID);?>" title="<?php echo $_about_page_tr->post_title;?>">
                      <?php echo $_about_page_tr->post_title;?>
                  </a>
              </li>
              <li>
                <a class="<?php echo pcdm_is_active(PcdmVideo::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link( PcdmVideo::TYPE_IDENTIFIER )?>" title="">
                    <?php _e('Videos')?>
                </a>
              </li>
              <li><a href="http://www.paulacademartori.tumblr.com/" target="_blank" title=""><?php _e('Diary')?></a></li>
              <li><a class="<?php echo pcdm_is_active(PcdmIcons::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link( PcdmIcons::TYPE_IDENTIFIER )?>" title="">Icons</a></li>
              <li><a class="<?php echo pcdm_is_active(PcdmNews::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link( PcdmNews::TYPE_IDENTIFIER )?>" title=""><?php _e('News')?></a></li>
              <li><a class="<?php echo pcdm_is_active(PcdmShoponline::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmShoponline::TYPE_IDENTIFIER )?>" title=""><?php _e('shop online')?></a></li>
              <li><a class="<?php echo pcdm_is_active(PcdmStore::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmStore::TYPE_IDENTIFIER )?>" title=""><?php echo _e('store list')?></a></li>
              <li><a class="<?php echo pcdm_is_active(PcdmPress::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmPress::TYPE_IDENTIFIER )?>" title=""><?php echo _e('Press Area')?></a></li>
            </ul>
          </nav> -->
          <!-- <nav class="choose-language">
            <ul>
              <?php foreach($languages as $lang):?>
              <li><a <?php if(pll_current_language() == $lang->slug):?>class="active"<?php endif;?> href="/<?php echo $lang->slug?>" title=""><?php echo $lang->name; ?></a></li>
              <?php endforeach;?>
            </ul>
          </nav>
          <nav class="nav-social">
            <span class="label"><?php _e('follow us')?></span>
            <ul class="js-last-child">
              <li class="facebook">
                <a  title="facebook" href="https://www.facebook.com/paulacademartoribrand" target="blank">Facebook</a>
              </li>
              <li class="histagram">
                <a title="instagram" href="http://instagram.com/pcademartori" target="blank">instagram</a>
              </li>
              <li class="twitter">
                <a title="twitter" href="https://twitter.com/PCademartori" target="blank">twitter</a>
              </li>
              <li class="pinterest">
                <a title="pinterest" href="http://www.pinterest.com/pcademartori/" target="blank">You Tube</a>
              </li>
              <li class="tumblr">
                <a title="tumblr" href="http://paulacademartori.tumblr.com/" target="blank">tumblr</a>
              </li>
            </ul>
          </nav> -->
        <!-- </div> -->
      <!-- </div> -->

      <div id="wrap-body">
        <div id="wrapper">
            <header class="header">
                <div class="fixed-mobile">
                  <div class="top-header"></div>
                  <a href="#" class="open-nav"></a>
                </div>
                <!-- <div class="right-navigation">
                    <div class="aux-right-navigation">
                        <nav class="choose-language">
                            <ul>
                              <?php foreach($languages as $lang):?>
                              <li><a <?php if(pll_current_language() == $lang->slug):?>class="active"<?php endif;?> href="/<?php echo $lang->slug?>" title=""><?php echo $lang->name; ?></a></li>
                              <?php endforeach;?>
                            </ul>
                        </nav>
                        <div class="wrap-navbar">
                            <nav class="navbar">
                                <ul class="first-level">
                                    <li class="dropdown">
                                        <a class="<?php echo pcdm_is_active('categories') ? 'active' : ''?>" href="#" title=""><?php echo _e('Collections')?></a>
                                        <div class="wrap-dropdown-menu">
                                            <ul class="dropdown-menu">
                                            <li>
                                                  <a class="" href="<?php echo get_page_link($pid2); ?>" title=""><?php echo $name2;?>
                                                      <span class="arrow-left"></span>
                                                      <span class="arrow-right"></span>
                                                  </a>
                                              </li>
                                                <li>
                                                  <a class="" href="<?php echo get_page_link($pid); ?>" title=""><?php echo $name;?>
                                                      <span class="arrow-left"></span>
                                                      <span class="arrow-right"></span>
                                                  </a>
                                              </li>
                                                <?php foreach(pcdm_get_season_terms() as $_term):?>
                                                    <?php if($_term->count):?>
                                                        <li>
                                                            <a href="<?php echo get_term_link($_term->slug, PcdmSeason::CATEGORY_IDENTIFIER)?>" title=""><?php echo $_term->name?>
                                                                <span class="arrow-left"></span>
                                                                <span class="arrow-right"></span>
                                                            </a
                                                        </li>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <?php
                                        $_about_page = get_page_by_title("About" );
                                        $_about_page_tr = get_page( pll_get_post($_about_page->ID, pll_current_language()) );
                                        ?>
                                        <a class="<?php echo pcdm_is_active('About') ? 'active' : ''?>" href="<?php echo get_page_link($_about_page_tr->ID);?>" title="<?php echo $_about_page_tr->post_title;?>">
                                            <?php echo $_about_page_tr->post_title;?>
                                        </a>
                                    </li>
                                    <li>
                                      <a class="<?php echo pcdm_is_active(PcdmVideo::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmVideo::TYPE_IDENTIFIER )?>" title="">
                                            <?php echo _e('Videos')?>
                                        </a>
                                    </li>
                                    <li><a href="http://www.paulacademartori.tumblr.com/" target="_blank" title=""><?php echo _e('Diary')?></a></li>
                                    <li><a class="<?php echo pcdm_is_active(PcdmIcons::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link( PcdmIcons::TYPE_IDENTIFIER )?>" title="">Icons</a></li>
                                    <li><a class="<?php echo pcdm_is_active(PcdmNews::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link( PcdmNews::TYPE_IDENTIFIER )?>" title=""><?php echo _e('News')?></a></li>
                                    <li><a class="<?php echo pcdm_is_active(PcdmShoponline::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmShoponline::TYPE_IDENTIFIER )?>" title=""><?php echo _e('shop online')?></a></li>
                                    <li><a class="<?php echo pcdm_is_active(PcdmStore::TYPE_IDENTIFIER) ? 'active' : ''?>" href="<?php echo get_post_type_archive_link(PcdmStore::TYPE_IDENTIFIER )?>" title=""><?php echo _e('store list')?></a></li>
                                </ul>
                            </nav>
                            <nav class="nav-social">
                                <span class="label">follow us</span>
                                <ul class="js-last-child">
                                    <li class="facebook">
                                        <a  title="facebook" href="https://www.facebook.com/paulacademartoribrand" target="blank">Facebook</a>
                                    </li>
                                    <li class="histagram">
                                        <a title="instagram" href="http://instagram.com/pcademartori" target="blank">instagram</a>
                                    </li>
                                    <li class="twitter">
                                        <a title="twitter" href="https://twitter.com/PCademartori" target="blank">twitter</a>
                                    </li>
                                    <li class="pinterest">
                                        <a title="pinterest" href="http://www.pinterest.com/pcademartori/" target="blank">You Tube</a>
                                    </li>
                                    <li class="tumblr">
                                        <a title="tumblr" href="http://paulacademartori.tumblr.com/" target="blank">tumblr</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div> -->
              <a href="<?php echo get_bloginfo('url')?>" class="logo"><img src="<?php echo pcdm_get_theme_resource('images/header/logo.png'); ?>"  alt="<?php _e('Paula Cademartori Logo: iconic buckle')?>"></a>
              <a href ="<?php echo get_bloginfo('url')?>" class="logo-small"><img src="<?php echo pcdm_get_theme_resource('images/header/logo-small.png'); ?>"  alt="<?php _e('Paula Cademartori Logo: iconic buckle')?>"></a>
            </header>

            <div class="container">
