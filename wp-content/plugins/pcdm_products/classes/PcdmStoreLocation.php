<?php

class PcdmStoreLocation {
  /**
   * Definisce il nome del tipo di dato che utilizziamo
   */

  const CATEGORY_IDENTIFIER = 'pcdm_storelocation';

  /**
   * Definisce il prefisso per i capi per questo tipo di dato
   */
  const CATEGORY_PREFIX = 'pcdm_storelocation_';

  public function __construct() {
    //definizione della tassonomia
    add_action('init', array(&$this, 'registerTaxonomy'));
  }

  public function registerTaxonomy() {
    $labels = array(
        'name' => _x('Location', 'taxonomy general name'),
        'singular_name' => _x('Store Location', 'taxonomy singular name'),
        'search_items' => __('Search a Store location'),
        'all_items' => __('All Store Location'),
        'edit_item' => __('Edit Store Location Info'),
        'update_item' => __('Update Store Location'),
        'add_new_item' => __('Add New Store Location'),
        'new_item_name' => __('New Store Location'),
    );


    $types = array(
        PcdmStore::TYPE_IDENTIFIER
    );

    $args = array(
        "hierarchical" => true,
        "labels" => $labels,
        'sort' => true,
        'rewrite' => false,
    );
    register_taxonomy(self::CATEGORY_IDENTIFIER, $types, $args);
  }

}

