<?php

define('DS', '/');
define('SKIN_SUBDIR', 'public');
define('PCDM_BASE_URL', get_bloginfo('url'));

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
    foreach($locations as $location){
      if($location->parent == 0){//continente
        if(!isset($res[$location->name])){
          $res[$location->name]=array();
        }
      }else{
        $parent = get_term( $location->parent, PcdmStoreLocation::CATEGORY_IDENTIFIER);
        if(!isset($res[$parent->name])){
          $res[$parent->name]=array();
        }
        if(!isset($res[$parent->name][$location->name])){
          $res[$parent->name][$location->name]=array();
        }
        $res[$parent->name][$location->name][]=packStoreElement($p, $meta);
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

function pcdm_get_map_link($coords){
  $coord_array=explode(",",$coords);
  if(count($coord_array)!=2){
    return false;
  }
  else{
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
      PcdmPress::TYPE_PREFIX . 'wall_image_id'
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

