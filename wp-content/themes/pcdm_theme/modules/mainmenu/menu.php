<?php
  $menu_args = array(
    'posts_per_page'   => -1,
    'offset'           => 0,
    'orderby'          => 'menu_order',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'main_menu',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'post_status'      => 'publish',
    'suppress_filters' => true
  );
  $counter = 1;
  $menu_items = get_posts( $menu_args );
?>
<?php
    global $polylang;
    if (isset($polylang)){
      $languages = $polylang->model->get_languages_list();
    }else{
      $languages = array();
    }

    ?>
<div class="main-menu" id="main-menu">
  <div class="main-menu__items">
    <!-- <div class="main-menu__item only-mobile-menu">
      <a href="/" class="main-menu-label">
        <span>Home</span>
      </a>
    </div> -->
    <?php foreach ( $menu_items as $post ) : setup_postdata( $post ); ?>
      <div class="main-menu__item">
        <div class="main-menu-label">
          <span><?php the_title();?></span>
        </div>
      </div>
    <?php endforeach; wp_reset_postdata();?>
      <div class="main-menu__social">
        <a  title="facebook" href="https://www.facebook.com/paulacademartoribrand" target="blank"><span class="icon icon-facebook"></span></a>
        <a title="instagram" href="http://instagram.com/pcademartori" target="blank"><span class="icon icon-instagram"></span></a>
        <a title="twitter" href="https://twitter.com/PCademartori" target="blank"><span class="icon icon-twitter"></span></a>
        <a title="pinterest" href="http://www.pinterest.com/pcademartori/" target="blank"><span class="icon icon-pinterest"></span></a>
        <a title="tumblr" href="http://paulacademartori.tumblr.com/" target="blank"><span class="icon icon-tumblr"></span></a>
        <?php foreach($languages as $lang):?>
          <a class="lang <?php   if(get_locale()== $lang->description):?>active<?php endif;?>"  href="/<?php echo $lang->slug?>" title=""><?php echo $lang->name; ?></a>
        <?php endforeach;?>
      </div>
  </div>
</div>

<div class="main-menu__subs" id="main-menu__subs">
  <?php foreach ( $menu_items as $post ) : setup_postdata( $post ); ?>
    <?php
      $type = get_field('type_of_menu');
      switch ($type) {
        case 'type1':
          include(locate_template('modules/mainmenu/type1.php'));
          break;
        case 'type2':
          include(locate_template('modules/mainmenu/type2.php'));
          break;
      }
    ?>
  <?php endforeach; wp_reset_postdata();?>
</div>
