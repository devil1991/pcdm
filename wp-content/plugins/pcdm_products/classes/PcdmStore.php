<?php

class PcdmStore {
  /**
   * Definisce il nome del tipo di dato che utilizziamo
   */

  const TYPE_IDENTIFIER = 'pcdm_store';

  /**
   * Definisce il prefisso per i capi per questo tipo di dato
   */
  const TYPE_PREFIX = 'pcdm_store_';

  public function __construct() {
    add_action('init', array(&$this, 'defineType'));
    add_filter('cmb_meta_boxes', array(&$this, 'defineFields'));
  }

  /**
   * Definisce il tipo di dato Prodotto da console di amministrazione         
   */
  public function defineType() {

    $labels = array(
        'name' => _x('Store', 'post type general name'),
        'singular_name' => _x('Store', 'post type singular name'),
        'add_new' => _x('Add New', 'home item'),
        'add_new_item' => __('Add Store'),
        'edit_item' => __('Edit Store Item'),
        'new_item' => __('New Store Item'),
        'view_item' => __('View Store Item'),
        'search_items' => __('Search Store'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'store',
            'with_front' => false
        ),
        'capability_type' => 'post',
        'hierarchical' => false, //non presenta gerarchia
        'menu_position' => null,
        'has_archive' => true,
        'supports' => array('title')
    );

    register_post_type(self::TYPE_IDENTIFIER, $args);
  }

  public function defineFields($meta_boxes) {

        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_1',
            'title' => 'Informations',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true,
            'fields' => array(
                array(
                    'name' => 'Address',
                    'desc' => 'Insert the address',
                    'id' => self::TYPE_PREFIX . 'address',
                    'type' => 'text_medium'
                ),
                array(
                    'name' => 'Cap',
                    'desc' => 'Insert Cap',
                    'id' => self::TYPE_PREFIX . 'cap',
                    'type' => 'text_medium'
                ),
                array(
                    'name' => 'Phone',
                    'desc' => 'Insert Phone number',
                    'id' => self::TYPE_PREFIX . 'phone',
                    'type' => 'text_medium'
                ),
                array(
                    'name' => 'Coords',//https://maps.google.it/maps?q=44.408278,10.189025&num=1&t=h&z=16
                    'desc' => 'Insert comma separated coordinates (eg: 44.408278,10.189025)',
                    'id' => self::TYPE_PREFIX . 'coords',
                    'type' => 'text_medium'
                ),
            ),
        );

    return $meta_boxes;
  }

}