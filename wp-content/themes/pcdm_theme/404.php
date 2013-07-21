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

<section>
  <div>
    <div>
      <code>  
        <?php
        global $wp_rewrite;
        foreach($wp_rewrite->rules as $a => $rule){
          echo sprintf("<pre>%s => %s</pre>",print_r($a,true),print_r($rule,true));
        }
        ?>  
      </code>
    </div>
  </div>
</section>

<?php get_footer(); ?>