<?php
// Register Custom Post Type
function main_menu_register() {

  $labels = array(
    'name'                => _x( 'Main Menu Items', 'Post Type General Name', 'text_domain' ),
    'singular_name'       => _x( 'Main Menu Item', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'           => __( 'Main Menu', 'text_domain' ),
    'name_admin_bar'      => __( 'Main Menu', 'text_domain' ),
    'parent_item_colon'   => __( 'Menu Item', 'text_domain' ),
    'all_items'           => __( 'Menu Items', 'text_domain' ),
    'add_new_item'        => __( 'Add Menu Item', 'text_domain' ),
    'add_new'             => __( 'Add New', 'text_domain' ),
    'new_item'            => __( 'New Menu Item', 'text_domain' ),
    'edit_item'           => __( 'Edit Menu Item', 'text_domain' ),
    'update_item'         => __( 'Update Menu Item', 'text_domain' ),
    'view_item'           => __( 'View Menu Item', 'text_domain' ),
    'search_items'        => __( 'Search Item', 'text_domain' ),
    'not_found'           => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
    'label'               => __( 'main_menu', 'text_domain' ),
    'description'         => __( 'Main Menu Posts', 'text_domain' ),
    'labels'              => $labels,
    'supports'            => array( ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-list-view',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
  );
  register_post_type( 'main_menu', $args );

}

// Hook into the 'init' action
add_action( 'init', 'main_menu_register', 0 );


add_action( 'after_setup_theme', 'menu_image_setup' );
function menu_image_setup() {
  add_image_size( 'menu-thumb', 350, 250, true ); // (cropped)
  add_image_size( 'menu-thumb2', 400, 285, true ); // (cropped)
}

add_filter('pll_get_post_types', 'my_pll_get_post_types');
function my_pll_get_post_types($types) {
    return array_merge($types, array('main_menu' => 'main_menu'));
}