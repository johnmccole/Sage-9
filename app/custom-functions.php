<?php

namespace App;

// Add after theme setup
add_action( 'after_setup_theme', function () {
  // Add extra Gutenberg alignment
  add_theme_support( 'align-wide' );
  // Disable custom font sizes
  add_theme_support( 'disable-custom-font-sizes' );
  // Add custom line height
  // add_theme_support( 'custom-line-height' );
  // Add responsive embeds support
  add_theme_support( 'responsive-embeds' );
  // Add custom padding
  add_theme_support( 'custom-spacing' );
  // Add appearance tools
  add_theme_support( 'appearance-tools' );
} );

// Font sizes in Gutenberg
add_theme_support(
    'editor-font-sizes',
    array(
      array(
          'name'      => __( 'Small', 'sage' ),
          'shortName' => __( 'S', 'sage' ),
          'size'      => 12,
          'slug'      => 'Small'
      ),
      array(
          'name'      => __( 'Body', 'sage' ),
          'shortName' => __( 'R', 'sage' ),
          'size'      => 16,
          'slug'      => 'body'
      ),
        array(
            'name'      => __( 'H6', 'sage' ),
            'shortName' => __( 'H6', 'sage' ),
            'size'      => 20,
            'slug'      => 'h6'
        ),
        array(
            'name'      => __( 'H5', 'sage' ),
            'shortName' => __( 'H5', 'sage' ),
            'size'      => 25,
            'slug'      => 'h5'
        ),
        array(
            'name'      => __( 'H4', 'sage' ),
            'shortName' => __( 'H4', 'sage' ),
            'size'      => 31.25,
            'slug'      => 'h4'
        ),
        array(
            'name'      => __( 'H3', 'sage' ),
            'shortName' => __( 'H3', 'sage' ),
            'size'      => 39.06,
            'slug'      => 'h3'
        ),
        array(
            'name'      => __( 'H2', 'sage' ),
            'shortName' => __( 'H2', 'sage' ),
            'size'      => 48.83,
            'slug'      => 'h2'
        ),
        array(
            'name'      => __( 'H1', 'sage' ),
            'shortName' => __( 'H1', 'sage' ),
            'size'      => 61.04,
            'slug'      => 'h1'
        ),
        array(
            'name'      => __( 'Display', 'sage' ),
            'shortName' => __( 'Display', 'sage' ),
            'size'      => 76.29,
            'slug'      => 'display'
        )
    )
);

// Rename posts in the admin menu
add_action('init', function() {
    if( function_exists('acf_add_options_page') ) {

      $rename = get_field('rename_posts', 'option');

      if($rename) {

        add_action( 'admin_menu', function() {
          $new_name = get_field('posts_new_name', 'option');
          $singular_name = get_field('post_singular_name', 'option');
          global $menu;
          global $submenu;
          $submenu['edit.php'][5][0]   = $new_name;
          $submenu['edit.php'][10][0]  = 'Add new '.$singular_name;
          $submenu['edit.php'][16][0]  = 'Tags';
          $menu[5][0]                  = $new_name;
        }  );


        // Rename the buttons/labels in the Post section
        add_action( 'init', function() {
          $new_name = get_field('posts_new_name', 'option');
          $singular_name = get_field('post_singular_name', 'option');
          global $wp_post_types;
          $labels                      = &$wp_post_types['post']->labels;
          $labels->name                = $new_name;
          $labels->singular_name       = $singular_name;
          $labels->add_new             = 'Add '.$singular_name;
          $labels->add_new_item        = 'Add '.$singular_name;
          $labels->edit_item           = 'Edit '.$singular_name;
          $labels->new_item            = $singular_name;
          $labels->view_item           = 'View '.$new_name;
          $labels->search_items        = 'Search '.$new_name;
          $labels->not_found           = 'No '.$new_name.' found';
          $labels->not_found_in_trash  = 'No '.$new_name.' found in Trash';
          $labels->all_items           = 'All '.$new_name;
          $labels->menu_name           = $new_name;
          $labels->name_admin_bar      = $new_name;
        }  );
      }
    }
});


// ACF Pro Options Page(s)
if( function_exists('acf_add_options_page') ) {

  $option_page = acf_add_options_page(array(
    'page_title' 	=> 'Theme Settings',
    'menu_title' 	=> 'Theme Settings',
    'menu_slug' 	=> 'them-settings',
    'capability' 	=> 'edit_posts',
    'icon_url'    => 'dashicons-welcome-view-site',
    'redirect'    => false,
    'position'    => 2,
	));

	$option_page = acf_add_options_page(array(
    'page_title' 	=> 'Custom Post Type Manager',
    'menu_title' 	=> 'Custom Post Type Manager',
    'menu_slug' 	=> 'custom-post-types',
    'capability' 	=> 'edit_posts',
    'icon_url'    => 'dashicons-welcome-widgets-menus',
    'redirect'    => false,
    'position'    => 3,
	));

  add_action( 'after_setup_theme', function () {
    // Add custom colours to palette
    $colours = get_field('colours', 'options');
    foreach($colours as $col) {
      $name     = esc_attr__($col['name'], 'default');
      $slug     = sanitize_title_with_dashes($col['name']);
      $colour   = $col['colour'];
      $newColorPalette[] = array('name' => $name, 'slug' => $slug, 'color' => $colour);
    }
    add_theme_support( 'editor-color-palette', $newColorPalette );

    // Enable Gutenberg in WooCommerce product
    if ( class_exists( 'woocommerce' ) ) {
      if( get_field('use_gutenberg', 'options') ):
        add_filter( 'use_block_editor_for_post_type', function ( $can_edit, $post_type ) {

            if ( $post_type == 'product' ) {
                $can_edit = true;
            }
            return $can_edit;
        }, 10, 2 );
      endif;
    }
  });

}

// AJAX update cart totals
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
    ob_start();
    ?>
<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="hidden-xs"><?php echo sprintf (_n( '%d</span>' . ' <span class="item-count"> item</span>', '%d</span>' . ' <span class="item-count"> items</span>', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - </span><?php echo WC()->cart->get_cart_total(); ?></a>
    <?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
 
    return $fragments;
} );
