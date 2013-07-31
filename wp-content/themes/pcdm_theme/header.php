<?php
global $polylang;
if (isset($polylang)){
  $languages = $polylang->get_languages_list();
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
        <title><?php echo pcdm_filter_wp_title(); ?></title>   
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link href="<?php echo pcdm_get_theme_resource('styles/screen.min.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
        <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
      <div id="body-simulator">
      <div class="aux-body-simulator">
        <div class="close-menu"></div>
      <div id="mobile-sidebar">
        <div class="aux-mobile-sidebar">
          <a href="<?php echo get_bloginfo('url')?>" class="logo">Paula Cademartori</a>
          <nav class="navbar">
            <ul class="first-level">
              <li><a href="" title=""><?php echo _e('Icons')?></a></li>
              <li class="dropdown">
                <a class="" href="#" title=""><?php echo _e('Collections')?></a>
                <div class="wrap-dropdown-menu">
                      <ul class="dropdown-menu">
                          <?php foreach(get_terms(PcdmSeason::CATEGORY_IDENTIFIER) as $_term):?>
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
                  <a href="<?php echo get_page_link($_about_page_tr->ID);?>" title="<?php echo $_about_page_tr->post_title;?>">
                      <?php echo $_about_page_tr->post_title;?>
                  </a>
              </li>
              <li><a href="/videos" title=""><?php _e('Videos')?></a></li>
              <li><a href="" title=""><?php _e('Diary')?></a></li>
              <li><a href="<?php echo get_post_type_archive_link( PcdmNews::TYPE_IDENTIFIER )?>" title=""><?php _e('News')?></a></li>
              <li><a href="" title=""><?php _e('shop online')?></a></li>
            </ul>
          </nav>
          <nav class="choose-language">
            <ul>
              <?php foreach($languages as $lang):?>
              <li><a <?php if(pll_current_language() == $lang->slug):?>class="active"<?php endif;?> href="/<?php echo $lang->slug?>" title=""><?php echo $lang->name; ?></a></li>
              <?php endforeach;?>
            </ul>
          </nav>
          <nav class="nav-social">
            <ul class="js-last-child">
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
        </div>
      </div>
      
      <div id="wrap-body">
        <div id="wrapper">
            <header class="header">
                <div class="fixed-mobile">
                  <div class="top-header"></div>
                  <a href="#" class="open-nav"></a>
                </div>
                <div class="right-navigation">
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
                                    <li><a href="" title=""><?php echo _e('Icons')?></a></li>
                                    <li class="dropdown">
                                        <a class="" href="#" title=""><?php echo _e('Collections')?></a>
                                        <div class="wrap-dropdown-menu">
                                            <ul class="dropdown-menu">
                                                <?php foreach(get_terms(PcdmSeason::CATEGORY_IDENTIFIER) as $_term):?>
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
                                        <a href="<?php echo get_page_link($_about_page_tr->ID);?>" title="<?php echo $_about_page_tr->post_title;?>">
                                            <?php echo $_about_page_tr->post_title;?>
                                        </a>
                                    </li>
                                    <li><a href="" title=""><?php echo _e('Videos')?></a></li>
                                    <li><a href="" title=""><?php echo _e('Diary')?></a></li>
                                    <li><a href="<?php echo get_post_type_archive_link( PcdmNews::TYPE_IDENTIFIER )?>" title=""><?php echo _e('News')?></a></li>
                                    <li><a href="" title=""><?php echo _e('shop online')?></a></li>
                                </ul>
                            </nav>
                            <nav class="nav-social">
                                <ul class="js-last-child">
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
                        </div>
                    </div>
                </div>
              <a href="<?php echo get_bloginfo('url')?>" class="logo"><img src="<?php echo pcdm_get_theme_resource('images/header/logo.png'); ?>" alt=""></a>
                <a href ="<?php echo get_bloginfo('url')?>" class="logo-small"><img src="<?php echo pcdm_get_theme_resource('images/header/logo-small.png'); ?>" alt=""></a>
            </header>	

            <div class="container">