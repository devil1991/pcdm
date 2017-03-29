<?php

define('DS', '/');
define('PCDM_ALT_SEPARATOR', '#');
define('SKIN_SUBDIR', 'public');
define('PCDM_BASE_URL', get_bloginfo('url'));
define('MAINTENANCE', false);

$sage_includes = array("modules/mainmenu/register.php");

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);


add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );
add_theme_support('post-thumbnails');

function pcdm_get_hp_elements() {
//massimo peso in HP
  $max_fill_hp = 12;
//i pesi dei differenti template per gli elementi HP
  $home_tpls_weights = array(
      PcdmHomeElement::TPL_LARGE => 12,
      PcdmHomeElement::TPL_MEDIUM => 9,
      PcdmHomeElement::TPL_SMALL => 3,
      'void' => 3,
  );
//mi creo una struttura dati per ritornare gli elementi da mostrare
  $res = array(
      0 => array(
          'filled' => 0
      )
  );
//costruisco la query per recuperare gli elementi in HP
  $hp_element_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmHomeElement::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

//ciclo sugli elementi
  foreach (get_posts($hp_element_query) as $p) {
//recupero i meta dati per questo post
    $meta = get_post_meta($p->ID);
//recupero il template di questo elemento HP
    $template = isset($meta[PcdmHomeElement::TYPE_PREFIX . 'hp_template']) ? $meta[PcdmHomeElement::TYPE_PREFIX . 'hp_template'][0] : PcdmHomeElement::TPL_LARGE;
//ne controllo il peso
    $template_weight = $home_tpls_weights[$template];
    if ($meta[PcdmHomeElement::TYPE_PREFIX . 'void_after'][0] == 'on') {
      $template_weight += $home_tpls_weights['void'];
    }
//fallback di controllo
    $template_weight = ($template_weight > $max_fill_hp) ? $max_fill_hp : $template_weight;
//controllo se c'e' ancora dello spazio per inserire dei contenuti
    if ($res[count($res) - 1]['filled'] + $template_weight <= $max_fill_hp) {
//se c'e ancora spazio per inserire
      $res[count($res) - 1]['products'][] = packHpElement($p, $meta);
      $res[count($res) - 1]['filled']+=$template_weight;
    } else {
//altrimenti creo un altro spazio
      $res [] = array(
          'products' => array(packHpElement($p, $meta)),
          'filled' => $template_weight
      );
    }
  }
  return $res;
}

function packHpElement($hp_element, $meta) {
  $entity = array();

  $post_attributes = array(
      'ID',
      'post_title'
  );
  $post_meta_attributes = array(
      PcdmHomeElement::TYPE_PREFIX . 'hp_template',
      PcdmHomeElement::TYPE_PREFIX . 'hp_number',
      PcdmHomeElement::TYPE_PREFIX . 'description',
      PcdmHomeElement::TYPE_PREFIX . 'void_after',
      PcdmHomeElement::TYPE_PREFIX . 'home_image',
      PcdmHomeElement::TYPE_PREFIX . 'home_image_id',
      PcdmHomeElement::TYPE_PREFIX . 'align_left',
      PcdmHomeElement::TYPE_PREFIX . 'link_type',
      PcdmHomeElement::TYPE_PREFIX . 'hp_link',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $hp_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }
  $entity['parent_id'] = $hp_element->ID;
  return $entity;
}

function pcdm_get_store_archive() {
  $res = array();
  $store_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmStore::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

//ciclo sugli elementi
  foreach (get_posts($store_query) as $p) {
    $meta = get_post_meta($p->ID);
    $locations = wp_get_post_terms($p->ID, PcdmStoreLocation::CATEGORY_IDENTIFIER);
    foreach ($locations as $location) {
      if ($location->parent == 0) {//continente
        if (!isset($res[$location->name])) {
          $res[$location->name] = array();
        }
      } else {
        $parent = get_term($location->parent, PcdmStoreLocation::CATEGORY_IDENTIFIER);
        if (!isset($res[$parent->name])) {
          $res[$parent->name] = array();
        }
        if (!isset($res[$parent->name][$location->name])) {
          $res[$parent->name][$location->name] = array();
        }
        $res[$parent->name][$location->name][] = packStoreElement($p, $meta);
      }
    }
  }
  return $res;
}


function packStoreElement($store_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title'
  );
  $post_meta_attributes = array(
      PcdmStore::TYPE_PREFIX . 'address',
      PcdmStore::TYPE_PREFIX . 'cap',
      PcdmStore::TYPE_PREFIX . 'phone',
      PcdmStore::TYPE_PREFIX . 'coords',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $store_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }


  return $entity;
}

function pcdm_get_map_link($coords) {
  $coord_array = explode(",", $coords);
  if (count($coord_array) != 2) {
    return false;
  } else {
    return "https://maps.google.it/maps?q={$coord_array[0]},{$coord_array[1]}&num=1&t=h&z=16";
  }
}

function pcdm_get_home_element_class($element) {
  switch ($element[PcdmHomeElement::TYPE_PREFIX . 'hp_template']) {
    case PcdmHomeElement::TPL_LARGE:
      return 'big';
    case PcdmHomeElement::TPL_MEDIUM:
      return 'medium';
    case PcdmHomeElement::TPL_SMALL:
      return 'small';
  }
  return 'big';
}

function pcdm_get_home_link($element) {
  if (!is_null($element[PcdmHomeElement::TYPE_PREFIX . 'hp_link'])) {
    $hp_link = $element[PcdmHomeElement::TYPE_PREFIX . 'hp_link'];
    if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $hp_link)) {
      return $hp_link;
    } else {
      return get_bloginfo('url') . "/" . ltrim($hp_link, "/");
    }
  }
  return "";
}

function pcdm_get_shoponline_archive() {
  $res = array();
  //costruisco la query
  $shop_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmShoponline::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

  //ciclo sugli shop online
  foreach (get_posts($shop_query) as $p) {
    //recupero i meta
    $meta = get_post_meta($p->ID);
    //impacchetto l'elemento
    $element = packShoponlineElement($p, $meta);
    //verifico a quale lettera appartenga questo post
    $element[PcdmShoponline::TYPE_PREFIX . 'letter'] =
            isset($element[PcdmShoponline::TYPE_PREFIX . 'letter']) ?
            strtolower(substr(trim($element[PcdmShoponline::TYPE_PREFIX . 'letter']), 0, 1)) :
            strtolower(substr(trim($element['post_title']), 0, 1));
    //imposto correttamente i valori dei link
    if (isset($element[PcdmShoponline::TYPE_PREFIX . 'link'])) {
      if (!isset($element[PcdmShoponline::TYPE_PREFIX . 'textlink'])) {
        $element[PcdmShoponline::TYPE_PREFIX . 'textlink'] = $element[PcdmShoponline::TYPE_PREFIX . 'link'];
      }
    }
    if (!isset($res[$element[PcdmShoponline::TYPE_PREFIX . 'letter']])) {
      $res[$element[PcdmShoponline::TYPE_PREFIX . 'letter']] = array();
    }
    //assegno l'elemento alla lettera corretta
    $res[$element[PcdmShoponline::TYPE_PREFIX . 'letter']][] = $element;
  }

  ksort($res);

  return $res;
}

function packShoponlineElement($shop_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title'
  );
  $post_meta_attributes = array(
      PcdmShoponline::TYPE_PREFIX . 'description',
      PcdmShoponline::TYPE_PREFIX . 'letter',
      PcdmShoponline::TYPE_PREFIX . 'link',
      PcdmShoponline::TYPE_PREFIX . 'textlink',
      PcdmShoponline::TYPE_PREFIX . 'wall_image',
      PcdmShoponline::TYPE_PREFIX . 'wall_image_id',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $shop_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }

  return $entity;
}

function pcdm_get_video_archive() {
  $res = array();
  //costruisco la query
  $video_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmVideo::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

  //ciclo sugli shop online
  foreach (get_posts($video_query) as $p) {
    //recupero i meta
    $meta = get_post_meta($p->ID);
    //impacchetto l'elemento
    $element = packVideoElement($p, $meta);

    $res[] = $element;
  }

  return $res;
}

function pcdm_get_icons_archive() {
  $res = array();
  //costruisco la query
  $video_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmIcons::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

  //ciclo sugli shop online
  foreach (get_posts($video_query) as $p) {
    //recupero i meta
    $meta = get_post_meta($p->ID);
    //impacchetto l'elemento
    $element = packIconElement($p, $meta);

    $res[] = $element;
  }

  return $res;
}

function packIconElement($shop_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title'
  );
  $post_meta_attributes = array(
      PcdmIcons::TYPE_PREFIX . 'description',
      PcdmIcons::TYPE_PREFIX . 'video_link',
      PcdmIcons::TYPE_PREFIX . 'wall_image',
      PcdmIcons::TYPE_PREFIX . 'wall_image_id',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $shop_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }

  return $entity;
}


function packVideoElement($shop_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title'
  );
  $post_meta_attributes = array(
      PcdmVideo::TYPE_PREFIX . 'description',
      PcdmVideo::TYPE_PREFIX . 'video_link',
      PcdmVideo::TYPE_PREFIX . 'wall_image',
      PcdmVideo::TYPE_PREFIX . 'wall_image_id',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $shop_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }

  return $entity;
}

function pcdm_get_news_archive() {
//massimo peso in HP
  $max_fill_news_block = 2;
//i pesi dei differenti template per gli elementi HP
  $news_tpls_weights = array(
      PcdmNews::TPL_LARGE => 2,
      PcdmNews::TPL_SMALL => 1,
  );
  $res = array(
      0 => array(
          'filled' => 0
      )
  );
  $_element_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmNews::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );
  foreach (get_posts($_element_query) as $p) {
    $meta = get_post_meta($p->ID);
    $template = isset($meta[PcdmNews::TYPE_PREFIX . 'hp_template']) ? $meta[PcdmNews::TYPE_PREFIX . 'hp_template'][0] : PcdmNews::TPL_LARGE;
    $template_weight = $news_tpls_weights[$template];

    if ($res[count($res) - 1]['filled'] + $template_weight <= $max_fill_news_block) {
//se c'e ancora spazio per inserire
      $res[count($res) - 1]['news'][] = pack_news($p, $meta);
      $res[count($res) - 1]['filled']+=$template_weight;
    } else {
//altrimenti creo un altro spazio
      $res [] = array(
          'news' => array(pack_news($p, $meta)),
          'filled' => $template_weight
      );
    }
  }
  return $res;
}

function pcdm_get_press_archive() {
  $res = array();
  $_element_query = array(
      'posts_per_page' => -1,
      'offset' => 0,
      'category' => '',
      'include' => '',
      'exclude' => '',
      'meta_key' => '',
      'meta_value' => '',
      'post_type' => PcdmPress::TYPE_IDENTIFIER,
      'post_mime_type' => '',
      'post_parent' => '',
      'post_status' => 'publish'
  );

  foreach (get_posts($_element_query) as $p) {
    $meta = get_post_meta($p->ID);
    $res[] = pack_press($p, $meta);
  }

  return $res;
}

function pcdm_get_product_buckets($season, $terms) {
  $res = array();
  $bucketsArgs = array(
      'posts_per_page' => '-1',
      'post_type' => PcdmProductBucket::TYPE_IDENTIFIER,
      'tax_query' => array(array(
              'taxonomy' => $season,
              'field' => 'slug',
              'terms' => $terms
          ))
  );

  $buckets = get_posts($bucketsArgs);

  foreach ($buckets as $p) {
    $meta = get_post_meta($p->ID);
    $res[] = pack_bucket($p, $meta);
  }
  return $res;
}

function pack_news($_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title',
      'post_date'
  );
  $post_meta_attributes = array(
      PcdmNews::TYPE_PREFIX . 'abstract',
      PcdmNews::TYPE_PREFIX . 'hp_template',
      PcdmNews::TYPE_PREFIX . 'hover_color',
      PcdmNews::TYPE_PREFIX . 'wall_image',
      PcdmNews::TYPE_PREFIX . 'wall_image_id',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }


  return $entity;
}

function pack_press($_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title',
      'post_date'
  );
  $post_meta_attributes = array(
      PcdmPress::TYPE_PREFIX . 'wall_image',
      PcdmPress::TYPE_PREFIX . 'wall_image_id',
      PcdmPress::TYPE_PREFIX . 'pdf_file'
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }


  return $entity;
}

function pack_bucket($_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title',
      'post_date'
  );
  $post_meta_attributes = array(
      PcdmProductBucket::TYPE_PREFIX . 'prod_a',
      PcdmProductBucket::TYPE_PREFIX . 'prod_b',
      PcdmProductBucket::TYPE_PREFIX . 'prod_c',
      PcdmProductBucket::TYPE_PREFIX . 'prod_d',
      PcdmProductBucket::TYPE_PREFIX . 'collection_template',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }


  return $entity;
}

function pack_product($_element, $meta) {
  $entity = array();
  $post_attributes = array(
      'ID',
      'post_title',
      'post_date'
  );
  $post_meta_attributes = array(
      PcdmProduct::TYPE_PREFIX . 'description',
      PcdmProduct::TYPE_PREFIX . 'number',
      PcdmProduct::TYPE_PREFIX . 'collection_color',
      PcdmProduct::TYPE_PREFIX . 'detail_image',
      PcdmProduct::TYPE_PREFIX . 'detail_image_id',
      PcdmProduct::TYPE_PREFIX . 'wall_image',
      PcdmProduct::TYPE_PREFIX . 'wall_image_id',
      PcdmProduct::TYPE_PREFIX . 'text_color',
  );

  foreach ($post_attributes as $attr) {
    $entity[$attr] = $_element->$attr;
  }

  foreach ($post_meta_attributes as $attr) {
    $entity[$attr] = $meta[$attr][0];
  }


  return $entity;
}

function pcdm_get_new_wall_image_dim($element) {
  switch ($element[PcdmNews::TYPE_PREFIX . 'hp_template']) {
    case PcdmNews::TPL_LARGE:
      return explode(":", PcdmNews::TPL_LARGE_DIMENSIONS);
    case PcdmNews::TPL_SMALL:
      return explode(":", PcdmNews::TPL_SMALL_DIMENSIONS);
  }
  return explode(":", PcdmNews::TPL_LARGE_DIMENSIONS);
}

function pcdm_get_news_class($element) {
  switch ($element[PcdmNews::TYPE_PREFIX . 'hp_template']) {
    case PcdmNews::TPL_LARGE:
      return 'big';
    case PcdmNews::TPL_SMALL:
      return 'small';
  }
  return 'big';
}

/////////////////////////////// URL DEFINITIONS/////////////////////////////////
function pcdm_get_link($link) {
  return PCDM_BASE_URL . DS . $link;
}

/////////////////////////////// SKIN  FUNCTIONS/////////////////////////////////
function pcdm_get_theme_resource($resource) {
  return get_template_directory_uri() . DS . SKIN_SUBDIR . DS . $resource;
}

function pcdm_get_og_image() {
  global $wp_query;
  $queried_object = get_queried_object();
  $og_image = false;
  if (is_single()) {
    switch ($queried_object->post_type) {
      case PcdmProduct::TYPE_IDENTIFIER:
        $meta = get_post_meta($queried_object->ID);
        $_det_img = wp_get_attachment_image_src($meta[PcdmProduct::TYPE_PREFIX . 'detail_image_id'][0], PcdmProduct::TYPE_PREFIX . 'detail_image');
        $og_image = $_det_img[0];
        break;
    }
  }
  return $og_image;
}

function pcdm_filter_wp_title() {
  global $wp_query;
  $queried_object = get_queried_object();
  $append = "Paula Cademartori";
  if (is_single()) {
    switch ($queried_object->post_type) {
      case PcdmProduct::TYPE_IDENTIFIER:
        $seas = array_pop(get_the_terms($queried_object->ID, PcdmSeason::CATEGORY_IDENTIFIER));
        $filtered_title = "{$queried_object->post_title} - {$seas->name} | $append";
        break;
      case PcdmNews::TYPE_IDENTIFIER:
        $filtered_title = "{$queried_object->post_title}  | $append";
        break;
    }
  } else if (is_post_type_archive()) {
    switch ($queried_object->post_type) {
      case PcdmNews::TYPE_IDENTIFIER:
        $filtered_title = "News | $append";
        break;
      case PcdmPress::TYPE_IDENTIFIER:
        $filtered_title = "Press | $append";
        break;
    }
  } else if (is_tax(PcdmSeason::CATEGORY_IDENTIFIER)) {
    $filtered_title = "Collection {$queried_object->name} | $append";
  }
  return $filtered_title;
}

function pcdm_get_season_terms() {
  $numbered_terms = array();
  $not_numbered_terms = array();
  foreach (get_terms(PcdmSeason::CATEGORY_IDENTIFIER) as $_term) {
    $term_descriptions = explode(",", $_term->description);
    $number = intval(str_replace("/", "", $term_descriptions[0]));
    if (is_int($number)) {
      $numbered_terms[$number] = $_term;
    } else {
      $not_numbered_terms[] = $_term;
    }
  }
  ksort($numbered_terms);
  return array_merge($numbered_terms, $not_numbered_terms);
}

function pcdm_get_img_alt($attachment_id) {
  $_separator = PCDM_ALT_SEPARATOR;
  $alt = "";
  $_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
  $lang = pll_current_language();
  $alts = explode($_separator, $_alt);
  switch ($lang) {
    case "it":
      if (isset($alts[1]))
        return $alts[1];
    case "en":
      return $alts[0];
      break;
  }
  return $alt;
}

function pcdm_raw_query($sql) {
  global $wpdb;
  return $wpdb->get_results($sql);
}

/*
  CREATE  TABLE `wp_paula`.`seo_keys` (
  `code` VARCHAR(256) NOT NULL ,
  `value` LONGTEXT NULL ,
  PRIMARY KEY (`code`) );
 */

function pcdm_get_seo_key($key) {
  $res = pcdm_raw_query("SELECT value FROM seo_keys sk WHERE sk.code = '{$key}'");
  if (count($res)) {
    $occur = array_pop($res);
    return $occur->value;
  }
  return "";
}

function pcdm_get_seo_description() {
  global $wp_query;
  $queried_object = get_queried_object();

  if(is_home()){
    return pcdm_get_seo_key(sprintf("description_page_home_%s",  pll_current_language()));
  }else if (is_single()) {//controlla oggetto
    $post_meta = get_post_meta($queried_object->ID);
    switch ($queried_object->post_type) {
      case PcdmProduct::TYPE_IDENTIFIER:
        return $post_meta[PcdmProduct::TYPE_PREFIX.'seo_description'][0];
        break;
      case PcdmNews::TYPE_IDENTIFIER:
        return $post_meta[PcdmNews::TYPE_PREFIX.'seo_description'][0];
        break;
    }
  } else if (is_post_type_archive()) {
    return pcdm_get_seo_key(sprintf("description_archive_%s_%s", $queried_object->name, pll_current_language()));
  } else if (is_tax(PcdmSeason::CATEGORY_IDENTIFIER)) {
    return pcdm_get_seo_key(sprintf("description_category_%s_%s", $queried_object->slug, pll_current_language()));
  } else {
    return pcdm_get_seo_key(sprintf("description_page_%s_%s", $queried_object->post_name, pll_current_language()));
  }
}

function pcdm_is_active($section){
  global $wp_query;
  $queried_object = get_queried_object();
  if (is_post_type_archive()) {
    if(strpos($_SERVER['REQUEST_URI'], 'icons')!==FALSE && $section == PcdmIcons::TYPE_IDENTIFIER){
      return TRUE;
    }
    return $queried_object->name == $section;
  } else if (is_tax(PcdmSeason::CATEGORY_IDENTIFIER)) {
    return $section == 'categories';
  } else {
    return $queried_object->post_title == $section;
  }
  return false;
}


function pcdm_get_seo_title() {
  global $wp_query;
  $queried_object = get_queried_object();


  if(is_home()){
    return pcdm_get_seo_key(sprintf("title_page_home_%s",  pll_current_language()));
  }else if (is_single()) {//controlla oggetto
    $post_meta = get_post_meta($queried_object->ID);
    switch ($queried_object->post_type) {
      case PcdmProduct::TYPE_IDENTIFIER:
        return $post_meta[PcdmProduct::TYPE_PREFIX.'seo_title'][0];
        break;
      case PcdmNews::TYPE_IDENTIFIER:
        return $post_meta[PcdmNews::TYPE_PREFIX.'seo_title'][0];
        break;
    }
  } else if (is_post_type_archive()) {
    return pcdm_get_seo_key(sprintf("title_archive_%s_%s", $queried_object->name, pll_current_language()));
  } else if (is_tax(PcdmSeason::CATEGORY_IDENTIFIER)) {
    return pcdm_get_seo_key(sprintf("title_category_%s_%s", $queried_object->slug, pll_current_language()));
  } else {
    return pcdm_get_seo_key(sprintf("title_page_%s_%s", $queried_object->post_name, pll_current_language()));
  }
}
add_filter('body_class', 'multisite_body_classes');
function multisite_body_classes($classes) {
    if(get_field('fixed_scroll_layout',array_pop(get_the_terms($_product_id,  PcdmSeason::CATEGORY_IDENTIFIER)))  ){
      $classes[] = 'template-catalog-fixed';
      return $classes;
    }
    if( is_page_template( 'template-dundun.php' ) ){
      $classes[] = 'page-template-dundun';
      return $classes;
    }
    if( is_page_template( 'template-lotus.php' ) ){
      $classes[] = 'page-template-lotus';
      return $classes;
    }
}
add_filter('pll_copy_post_metas', 'copy_post_metas');
function copy_post_metas($metas) {
    if( is_page_template( 'template-dundun.php' ) ){
      return false;
    }
}
//ACF STARTS
// include_once('advanced-custom-fields/acf.php');

if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_layout-type',
    'title' => 'Layout Type',
    'fields' => array (
      array (
        'key' => 'field_545f346181868',
        'label' => 'Fixed Scroll Layout',
        'name' => 'fixed_scroll_layout',
        'type' => 'true_false',
        'message' => 'Use new layout style ?',
        'default_value' => 0,
      ),
      array (
        'key' => 'field_545f34b90c619',
        'label' => 'Preloader',
        'name' => 'preloader',
        'type' => 'image',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_545f346181868',
              'operator' => '==',
              'value' => '1',
            ),
          ),
          'allorany' => 'all',
        ),
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_545fecfd78758',
        'label' => 'Background Pattern',
        'name' => 'background_pattern',
        'type' => 'image',
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_545fff900fd72',
        'label' => 'Single Product BG',
        'name' => 'single_product_bg',
        'type' => 'image',
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_54627cab1ca00',
        'label' => 'Preloader Image',
        'name' => 'preloader_image',
        'type' => 'image',
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_5462923c036ca',
        'label' => 'Intro Text',
        'name' => 'intro_text',
        'type' => 'wysiwyg',
        'default_value' => '',
        'toolbar' => 'basic',
        'media_upload' => 'no',
      ),
      array (
        'key' => 'field_546292758c2f7',
        'label' => 'Vimeo Link',
        'name' => 'vimeo_link',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'ef_taxonomy',
          'operator' => '==',
          'value' => 'pcdm_season',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));
}
// pll_register_string('Watch the Video', 'Watch the Video');

if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_tuntun',
    'title' => 'TunTun',
    'fields' => array (
      array (
        'key' => 'field_5470d234087de',
        'label' => 'Intro Content',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_547083a91c7aa',
        'label' => 'Title',
        'name' => 'intro-title',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_547083c61c7ab',
        'label' => 'Info',
        'name' => 'intro-info',
        'type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'formatting' => 'none',
      ),
      array (
        'key' => 'field_5470c4464798b',
        'label' => 'Intro Video ',
        'name' => 'intro_video',
        'type' => 'repeater',
        'instructions' => 'Upload Multiple Formats for Browser Support',
        'sub_fields' => array (
          array (
            'key' => 'field_5470d1c86a285',
            'label' => 'Video',
            'name' => 'video',
            'type' => 'file',
            'column_width' => '',
            'save_format' => 'object',
            'library' => 'uploadedTo',
          ),
        ),
        'row_min' => 1,
        'row_limit' => '',
        'layout' => 'table',
        'button_label' => 'Add Video',
      ),
      array (
        'key' => 'field_5470d0faa4cde',
        'label' => 'Intro Canvas Image',
        'name' => 'intro_canvas_image',
        'type' => 'image',
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_5470d23f087df',
        'label' => 'Page Rows',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_5470ba8d8bff4',
        'label' => 'Rows',
        'name' => 'rows',
        'type' => 'repeater',
        'sub_fields' => array (
          array (
            'key' => 'field_5470baaf8bff5',
            'label' => 'Row Type',
            'name' => 'row_type',
            'type' => 'radio',
            'column_width' => '',
            'choices' => array (
              'type1' => 'Two Col',
              'type2' => 'Three Col',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'type1',
            'layout' => 'horizontal',
          ),
          array (
            'key' => 'field_5470c02d54650',
            'label' => 'Is Inverse',
            'name' => 'is_inverse',
            'type' => 'true_false',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type1',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'message' => '',
            'default_value' => 1,
          ),
          array (
            'key' => 'field_5470c49443342',
            'label' => 'Is 3d Gallery',
            'name' => 'is_3d_gallery',
            'type' => 'true_false',
            'instructions' => 'Is 3d Gallary ?',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type1',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'message' => '',
            'default_value' => 0,
          ),
          array (
            'key' => 'field_5470d116a4ce0',
            'label' => '3D Gallery BG ',
            'name' => '3d_gallery_bg',
            'type' => 'color_picker',
            'instructions' => 'Select the Background Color for Container',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type1',
                ),
                array (
                  'field' => 'field_5470c49443342',
                  'operator' => '==',
                  'value' => '1',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'default_value' => '',
          ),
          array (
            'key' => 'field_5470c53f2cb3b',
            'label' => '3d Gallary Images',
            'name' => '3d_gallary_images',
            'type' => 'gallery',
            'instructions' => 'Sort the images in order of rotation',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type1',
                ),
                array (
                  'field' => 'field_5470c49443342',
                  'operator' => '==',
                  'value' => '1',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
          array (
            'key' => 'field_5470bb4f8bff6',
            'label' => 'Big Image',
            'name' => 'big_image',
            'type' => 'image',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type1',
                ),
                array (
                  'field' => 'field_5470c49443342',
                  'operator' => '!=',
                  'value' => '1',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
          ),
          array (
            'key' => 'field_5470bce13782a',
            'label' => 'Text Box',
            'name' => 'text_box',
            'type' => 'textarea',
            'column_width' => '',
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => 2,
            'formatting' => 'none',
          ),
          array (
            'key' => 'field_5470bd1b3782b',
            'label' => 'Small Image',
            'name' => 'small_image',
            'type' => 'image',
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
          array (
            'key' => 'field_5470bd463782c',
            'label' => 'Medium Image 1',
            'name' => 'medium_image_1',
            'type' => 'image',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type2',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
          array (
            'key' => 'field_5470bdb03782d',
            'label' => 'Medium Image 2',
            'name' => 'medium_image_2',
            'type' => 'image',
            'conditional_logic' => array (
              'status' => 1,
              'rules' => array (
                array (
                  'field' => 'field_5470baaf8bff5',
                  'operator' => '==',
                  'value' => 'type2',
                ),
              ),
              'allorany' => 'all',
            ),
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
        ),
        'row_min' => 1,
        'row_limit' => '',
        'layout' => 'row',
        'button_label' => 'Add Row',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'template-dundun.php',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'the_content',
        1 => 'excerpt',
        2 => 'custom_fields',
        3 => 'discussion',
        4 => 'comments',
        5 => 'revisions',
        6 => 'slug',
        7 => 'author',
        8 => 'format',
        9 => 'categories',
        10 => 'tags',
        11 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
}

if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_lotus-sandal',
    'title' => 'Lotus Sandal',
    'fields' => array (
      array (
        'key' => 'field_552545e46b6cf',
        'label' => 'Brief',
        'name' => 'brief',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_554cd3d4c1773',
        'label' => 'Shop Now Link',
        'name' => 'shop_now_link',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'Shop Now Link',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_552546929a712',
        'label' => 'Countdown Time',
        'name' => 'countdown_time',
        'type' => 'text',
        'instructions' => 'YYYY/MM/DD',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_552546b59a713',
        'label' => 'Sandals',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_552546c49a714',
        'label' => 'Sandal Images',
        'name' => 'sandal_images',
        'type' => 'repeater',
        'sub_fields' => array (
          array (
            'key' => 'field_552546e99a715',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
        ),
        'row_min' => '',
        'row_limit' => '',
        'layout' => 'table',
        'button_label' => 'Add Block',
      ),
      array (
        'key' => 'field_552547eb9a716',
        'label' => 'Row 1',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_552547f49a717',
        'label' => 'Title',
        'name' => 'row1_title',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_552548379a718',
        'label' => 'Text',
        'name' => 'row1_text',
        'type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => 2,
        'formatting' => 'none',
      ),
      array (
        'key' => 'field_552583ca2c0be',
        'label' => 'Row Slider',
        'name' => 'row_slider',
        'type' => 'repeater',
        'sub_fields' => array (
          array (
            'key' => 'field_552583dc2c0bf',
            'label' => 'Row 1 Slider Image ',
            'name' => 'row_1_slider_image',
            'type' => 'image',
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
        ),
        'row_min' => '',
        'row_limit' => '',
        'layout' => 'table',
        'button_label' => 'Add Row',
      ),
      array (
        'key' => 'field_55254ae6af04c',
        'label' => 'Row 2',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_5525484c9a719',
        'label' => 'Title',
        'name' => 'row2_title',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5525485b9a71a',
        'label' => 'Text Block',
        'name' => 'row2_text_block',
        'type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => 2,
        'formatting' => 'none',
      ),
      array (
        'key' => 'field_552583f82c0c0',
        'label' => 'Row 2 Slider',
        'name' => 'row_slider_2',
        'type' => 'repeater',
        'sub_fields' => array (
          array (
            'key' => 'field_552583f82c0c1',
            'label' => 'Row 2 Slider Image ',
            'name' => 'row_2_slider_image',
            'type' => 'image',
            'column_width' => '',
            'save_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
          ),
        ),
        'row_min' => '',
        'row_limit' => '',
        'layout' => 'table',
        'button_label' => 'Add Row',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'template-lotus.php',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'the_content',
        1 => 'excerpt',
        2 => 'custom_fields',
        3 => 'discussion',
        4 => 'comments',
        5 => 'revisions',
        6 => 'author',
        7 => 'format',
        8 => 'featured_image',
        9 => 'categories',
        10 => 'tags',
        11 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
  'key' => 'group_5568385658f33',
  'title' => 'Product Options',
  'fields' => array (
    array (
      'key' => 'field_556838f339a38',
      'label' => 'Template Type',
      'name' => 'template_type',
      'type' => 'radio',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        'right' => 'Detail on Right',
        'bottom' => 'Detail on Bottom',
      ),
      'other_choice' => 0,
      'save_other_choice' => 0,
      'default_value' => 'right',
      'layout' => 'vertical',
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'pcdm_products',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'side',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;



if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
  'key' => 'group_555f4e26462c9',
  'title' => 'Menu Builder',
  'fields' => array (
    array (
      'key' => 'field_555f48ace7cef',
      'label' => 'Type of Menu',
      'name' => 'type_of_menu',
      'type' => 'select',
      'instructions' => 'Select the type of Menu Row',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        'type1' => '3 Columns Menu',
        'type2' => '1 + 1 + 1 Columns Menu',
      ),
      'default_value' => array (
        '' => '',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'ajax' => 0,
      'placeholder' => '',
      'disabled' => 0,
      'readonly' => 0,
    ),
    array (
      'key' => 'field_555f4901e7cf0',
      'label' => '3 Columns Menu',
      'name' => 'type1_menu',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'field_555f48ace7cef',
            'operator' => '==',
            'value' => 'type1',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'min' => '',
      'max' => '',
      'layout' => 'row',
      'button_label' => 'Add Link Block',
      'sub_fields' => array (
        array (
          'key' => 'field_555f4ae1e7cf9',
          'label' => 'Link Block Title',
          'name' => 'link_block_title',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'html',
          'maxlength' => '',
          'readonly' => 0,
          'disabled' => 0,
        ),
        array (
          'key' => 'field_555f4a87e7cf5',
          'label' => 'Links',
          'name' => 'links',
          'type' => 'repeater',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'row_min' => 1,
          'row_limit' => 3,
          'layout' => 'row',
          'button_label' => 'Add Link',
          'min' => 0,
          'max' => 0,
          'sub_fields' => array (
            array (
              'key' => 'field_555f4aa8e7cf6',
              'label' => 'Link Label',
              'name' => 'link_label',
              'type' => 'text',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'default_value' => '',
              'placeholder' => '',
              'prepend' => '',
              'append' => '',
              'formatting' => 'html',
              'maxlength' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
            array (
              'key' => 'field_555f4ac3e7cf8',
              'label' => 'Link Hover Image',
              'name' => 'link_hover_image',
              'type' => 'image',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'return_format' => 'id',
              'preview_size' => 'menu-thumb',
              'library' => 'all',
              'min_width' => '',
              'min_height' => '',
              'min_size' => '',
              'max_width' => '',
              'max_height' => '',
              'max_size' => '',
              'mime_types' => '',
            ),
            array (
              'key' => 'field_55697fbbc7df6',
              'label' => 'Link Type',
              'name' => 'link_type',
              'type' => 'radio',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'choices' => array (
                'season' => 'Season',
                'external' => 'External',
              ),
              'other_choice' => 0,
              'save_other_choice' => 0,
              'default_value' => '',
              'layout' => 'horizontal',
            ),
            array (
              'key' => 'field_555f4ab7e7cf7',
              'label' => 'Link HREF',
              'name' => 'link_href',
              'type' => 'taxonomy',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => array (
                array (
                  array (
                    'field' => 'field_55697fbbc7df6',
                    'operator' => '==',
                    'value' => 'season',
                  ),
                ),
              ),
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'taxonomy' => 'pcdm_season',
              'field_type' => 'radio',
              'allow_null' => 0,
              'add_term' => 0,
              'load_save_terms' => 0,
              'return_format' => 'object',
              'multiple' => 0,
            ),
            array (
              'key' => 'field_55697feec7df7',
              'label' => 'External Link',
              'name' => 'external_link',
              'type' => 'url',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => array (
                array (
                  array (
                    'field' => 'field_55697fbbc7df6',
                    'operator' => '==',
                    'value' => 'external',
                  ),
                ),
              ),
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'default_value' => '',
              'placeholder' => '',
            ),
          ),
        ),
      ),
    ),
    array (
      'key' => 'field_555f4a1ae7cf4',
      'label' => '1 + 1 + 1 Columns Menu',
      'name' => 'type2_menu',
      'type' => 'flexible_content',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'field_555f48ace7cef',
            'operator' => '==',
            'value' => 'type2',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'button_label' => 'Add Link Block',
      'min' => 1,
      'max' => 2,
      'layouts' => array (
        array (
          'key' => '55624441189f6',
          'name' => 'link_block',
          'label' => 'Link Block',
          'display' => 'block',
          'sub_fields' => array (
            array (
              'key' => 'field_5562446039333',
              'label' => 'Link Main Label',
              'name' => 'link_block_title',
              'type' => 'text',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'default_value' => '',
              'placeholder' => '',
              'prepend' => '',
              'append' => '',
              'maxlength' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
            array (
              'key' => 'field_55624524292a2',
              'label' => 'Links',
              'name' => 'links',
              'type' => 'repeater',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'min' => 1,
              'max' => '',
              'layout' => 'row',
              'button_label' => 'Add Link',
              'sub_fields' => array (
                array (
                  'key' => 'field_5562452e292a3',
                  'label' => 'Link Label',
                  'name' => 'link_label',
                  'type' => 'text',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                  'prepend' => '',
                  'append' => '',
                  'maxlength' => '',
                  'readonly' => 0,
                  'disabled' => 0,
                ),
                array (
                  'key' => 'field_55624534292a4',
                  'label' => 'Link Hover Image',
                  'name' => 'link_hover_image',
                  'type' => 'image',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'return_format' => 'id',
                  'preview_size' => 'menu-thumb',
                  'library' => 'all',
                  'min_width' => '',
                  'min_height' => '',
                  'min_size' => '',
                  'max_width' => '',
                  'max_height' => '',
                  'max_size' => '',
                  'mime_types' => '',
                ),
                array (
                  'key' => 'field_55697e5b198f2',
                  'label' => 'Link Type',
                  'name' => 'link_type',
                  'type' => 'radio',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'choices' => array (
                    'season' => 'Season',
                    'external' => 'External',
                  ),
                  'other_choice' => 0,
                  'save_other_choice' => 0,
                  'default_value' => '',
                  'layout' => 'horizontal',
                ),
                array (
                  'key' => 'field_55624539292a5',
                  'label' => 'Link Href',
                  'name' => 'link_href',
                  'type' => 'taxonomy',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => array (
                    array (
                      array (
                        'field' => 'field_55697e5b198f2',
                        'operator' => '==',
                        'value' => 'season',
                      ),
                    ),
                  ),
                  'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'taxonomy' => 'pcdm_season',
                  'field_type' => 'radio',
                  'allow_null' => 0,
                  'add_term' => 0,
                  'load_save_terms' => 0,
                  'return_format' => 'object',
                  'multiple' => 0,
                ),
                array (
                  'key' => 'field_55697ea5198f3',
                  'label' => 'External Link',
                  'name' => 'external_link',
                  'type' => 'url',
                  'instructions' => '',
                  'required' => 0,
                  'conditional_logic' => array (
                    array (
                      array (
                        'field' => 'field_55697e5b198f2',
                        'operator' => '==',
                        'value' => 'external',
                      ),
                    ),
                  ),
                  'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                ),
              ),
            ),
          ),
          'min' => '',
          'max' => '',
        ),
        array (
          'key' => '556244bc0d009',
          'name' => 'link_image_block',
          'label' => 'Link Image Block',
          'display' => 'block',
          'sub_fields' => array (
            array (
              'key' => 'field_556244cd0d00a',
              'label' => 'Link Image',
              'name' => 'link_image',
              'type' => 'image',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'return_format' => 'id',
              'preview_size' => 'menu-thumb',
              'library' => 'all',
              'min_width' => '',
              'min_height' => '',
              'min_size' => '',
              'max_width' => '',
              'max_height' => '',
              'max_size' => '',
              'mime_types' => '',
            ),
            array (
              'key' => 'field_556244d30d00b',
              'label' => 'Link HREF',
              'name' => 'link_href',
              'type' => 'url',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'default_value' => '',
              'placeholder' => '',
            ),
            array (
              'key' => 'field_556244db0d00c',
              'label' => 'Link Label',
              'name' => 'link_label',
              'type' => 'text',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'default_value' => '',
              'placeholder' => '',
              'prepend' => '',
              'append' => '',
              'maxlength' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
          ),
          'min' => '',
          'max' => '',
        ),
      ),
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'main_menu',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'permalink',
    1 => 'the_content',
    2 => 'excerpt',
    3 => 'custom_fields',
    4 => 'discussion',
    5 => 'comments',
    6 => 'revisions',
    7 => 'slug',
    8 => 'author',
    9 => 'format',
    10 => 'featured_image',
    11 => 'categories',
    12 => 'tags',
    13 => 'send-trackbacks',
  ),
));

endif;




if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
  'key' => 'group_565c1653d53ab',
  'title' => 'Link Status',
  'fields' => array (
    array (
      'key' => 'field_565c170345e0d',
      'label' => 'Mark as True if NOT a Link',
      'name' => 'not_a_link',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 0,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'pcdm_products',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'side',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58d1388ed99c6',
	'title' => 'Shoppable',
	'fields' => array (
		array (
			'key' => 'field_58d138a70ed03',
			'label' => 'Shoppable Link',
			'name' => 'shoppable_link',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),

	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'pcdm_products',
			),
		),
    array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'pcdm_hpelement',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58d8c29cd997b',
	'title' => 'Video Products Content',
	'fields' => array (
		array (
			'key' => 'field_58d8c2ac36222',
			'label' => 'Youtube ID',
			'name' => 'youtube_id',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_58d8c2bb36223',
			'label' => 'Products',
			'name' => 'products',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'pcdm_products',
			),
			'taxonomy' => array (
			),
			'filters' => array (
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'elements' => array (
				0 => 'featured_image',
			),
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template-videoproducts.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'featured_image',
		11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
	),
));

endif;

function mycustomstyles () {
  wp_enqueue_style( 'v2style', get_template_directory_uri() . '/public/css/v2.css');
}
add_action('wp_enqueue_scripts', 'mycustomstyles');


function product_seasons__rel_query( $args, $field, $post_id ) {

    // only show children of the current post being edited
    $args['tax_query'] = array(
			'taxonomy' => 'pcdm_season'
		);

	// return
    return $args;

}


// filter for a specific field based on it's key
add_filter('acf/fields/relationship/query/key=group_58d8c29cd997b', 'product_seasons__rel_query', 10, 3);
error_reporting(0);
