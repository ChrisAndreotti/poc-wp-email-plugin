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
