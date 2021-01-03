<?php

/*
Plugin Name: Snappy List Builder
Plugin URI: http://wordpressplugincourse.com/plugins/snappy-list-builder
Description: The ultimate email list building plugin for WordPress. Capture new subscribers. Reward subscribers with a custom download upon opt-in. Build unlimited lists. Import and export subscribers easily with .csv
Version: 1.0
Author: Chris Andreotti
Author URI: https://twitter.com/ChrisAndreotti
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: snappy-list-builder
*/


/* HOOKS */

//register all of our custom shortcodes on init
add_action( 'init', 'slb_register_shortcodes');

//register custom admin column headers
add_filter('manage_edit-slb_subscriber_columns', 'slb_subscriber_column_headers');

//register custom admin column data
add_filter('manage_slb_subscriber_posts_custom_column', 'slb_subscriber_column_data', 1, 2);
add_action('admin_head-edit.php', 'slb_register_custom_admin_titles');


/* SHORTCODES */

function slb_register_shortcodes( ) {
  add_shortcode('slb_form', 'slb_form_shortcode');
}

function slb_form_shortcode( $args, $content="" ) {
  $output = '
    <div class="slb">
      <form id="slb_form" name="slb_form" class="" method="POST">
        <p class="slb-input-container">
          <label>Your name</label><br/>
          <input type="text" name="slb_fname" placeholder="First Name" />
          <input type="text" name="slb_lname" placeholder="Last Name" />
        </p>

        <p class="slb-input-container">
          <label>Your email</label><br/>
          <input type="email" name="slb_email" placeholder="ex: your@email.com" />
        </p>
      </form>
    </div>
  ';

  if ( strlen( $content ) ) {
    $output .= '<div class="slb-content">' . wpautop( $content ) . '</div>';
  }

  $output .= '<p class="slb-input-container"><input type="submit" name="slb_submit" value="Sign me up!">';

  return $output;
}

/* FILTERS */

function slb_subscriber_column_headers( $columns ) {

  //creating custom column header data
  $columns = array(
    'cb' => '<input type="checkbox">',
    'title' => __('Subscriber Name'),
    'email' => __('Email Address'),
  );

  //returning new columns
  return $columns;
}

function slb_subscriber_column_data( $column, $post_id ) {
  $output = '';

  switch( $column ) {
    case 'title':
      $fname = get_field('slb_fname', $post_id);
      $lname = get_field('slb_lname', $post_id);
      $output .= $fname . ' ' . $lname;
      break;
    case 'email':
      $email = get_field('slb_email', $post_id);
      $output .= $email;
      break;
  }

  echo $output;
}

//register custom admin title column
function slb_register_custom_admin_titles() {
  add_filter(
    'the_title', 
    'slb_custom_admin_titles', 
    99, 
    2
  );
}

//handle custom admin title "title" column data for post types without titles
//this fixes the "Auto Draft" text from appearing by default
function slb_custom_admin_titles( $title, $post_id ) {
  global $post;
  $output = $title;

  if ( isset( $post->post_type ) ):
    switch( $post->post_type ) {
      case 'slb_subscriber':
        $fname = get_field('slb_fname', $post_id);
        $lname = get_field('slb_lname', $post_id);
        $output = $fname . ' ' . $lname;
        break;
    }
  endif;

  return $output;
}
