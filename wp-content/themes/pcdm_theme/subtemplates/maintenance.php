<!DOCTYPE html>
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
        <title>Maintenance</title>   
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link href="<?php echo pcdm_get_theme_resource('styles/screen.min.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
        <script src="<?php echo pcdm_get_theme_resource('scripts/lib/modernizr-2.6.1.js'); ?>public/modernizr-2.6.1.js" type="text/javascript" charset="utf-8"></script>
        <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>
<body>
 <div class="wrap-404">
    <div class="aux">
      <a href="index.html" class="logo"><img src="<?php echo pcdm_get_theme_resource('images/header/logo.png'); ?>" alt="Paula Cademartori"></a>
      <div class="wrap-content" style="text-align:center;margin-top:0px">
        <div class="wrap-text" style="padding-left:0;padding-top:3em;">
          <h2 style="background:none;">
            Sorry, we are down <br>for maintenance. <br>We will be back up shortly.</h2>
        </div>
        <img style="width:470px;" src="<?php echo pcdm_get_theme_resource('images/borsa.gif'); ?>" alt="Paula Cademartori">
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="wrap-credits">
      <p>&copy; Paula cademartori. - All rights reserved</p>
    </div>
  </footer>
</body>
</html>