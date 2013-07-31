<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>

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

<?php get_footer(); ?>