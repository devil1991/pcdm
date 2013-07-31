<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>404</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link href="<?php echo pcdm_get_theme_resource('styles/screen.min.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
  <script src="<?php echo pcdm_get_theme_resource('scripts/lib/modernizr-2.6.1.js'); ?>" type="text/javascript" charset="utf-8"></script>
</head>
<body>

 <div class="wrap-404">
    <div class="aux">
      <a href="/" class="logo"><img src="<?php echo pcdm_get_theme_resource('images/header/logo.png'); ?>" alt="Paula Cademartori"></a>
      <div class="wrap-content">
        <div class="col-dx">
          <div class="wrap-text">
            <span class="number">/404</span>
            <h2>Page not found</h2>
            <p class="description">We’re sorry but we can’t seem to find the page you are looking for.
                In case you need any help, please don’t hesitate to contact us:</p>
            <a class="mail" href="mailto:info@paulacademartori.com">info@paulacademartori.com</a>
            <a href="/" class="back"><span>Back to site</span></a>
          </div>
        </div>
        <div class="col-sx">
          <img src="<?php echo pcdm_get_theme_resource('images/borsa.gif'); ?>" alt="Paula Cademartori">
        </div>
      </div>
    </div>
  </div>

</body>
</html>