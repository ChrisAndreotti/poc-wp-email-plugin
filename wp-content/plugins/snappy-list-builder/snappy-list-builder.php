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

add_action( 'init', 'slb_register_shortcodes');

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

/* MISC */

function slb_add_subscriber_metaboxes( $post ) {
  add_meta_box(
    'slb_subscriber_details', //unique-id
    'Subscriber Details', //title of metabox
    'slb_subscriber_metabox', //callable function that generates html inputs
    'slb_subscriber', //screen where it should appear
    'normal', //context where it should appear on the screen
    'default', //priority
  );
}

add_action( 'add_meta_boxes_slb_subscriber', 'slb_add_subscriber_metaboxes');

function slb_subscriber_metabox() {

  wp_nonce_field( basename( __FILE__ ), 'slb_subscriber_nonce' );

  ?>
  <style>
    .slb-field-row {
      display: flex;
      flex-flow: row nowrap;
      flex: 1 1;
    }
    .slb-field-container {
      postition: relative;
      flex: 1 1;
      margin: 1em;
    }
    .slb-field-container label {
      font-weight: bold;
    }
    .slb-field-container label span {
      color: red;
    }
    .slb-field-container ul {
      list-style: none;
      margin-top: 1em;
    }
    .slb-field-container ul label {
      font-weight: normal;
    }
  </style>

  <div class="slb-field-row">
    <div class="slb-field-container">
      <label>First Name <span>*</span></label><br/>
      <input type="text" name="slb_first_name" required="required" class="widefat" />
    </div>
    <div class="slb-field-container">
      <label>Last Name <span>*</span></label><br/>
      <input type="text" name="slb_last_name" required="required" class="widefat" />
    </div>
  </div>
  <div class="slb-field-row">
    <div class="slb-field-container">
      <label>Email <span>*</span></label><br/>
      <input type="email" name="slb_email" required="required" class="widefat" />
    </div>
  </div>
  <div class="slb-field-row">
    <div class="slb-field-container">
      <label>Lists</label><br/>
      <ul>
        <?php
          global $wpdb;

          $list_query = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'slb_list' AND post_status IN ('draft', 'publish')");

          if ( !is_null( $list_query ) ) {
            foreach ( $list_query as $list ) {
              echo '<li><label><input type="checkbox" name="slb_list[]" value="' . $list->ID . '" />' . $list->post_title . '</label></li>';
            }
          }
        ?>
      </ul>
    </div>
  </div>
  <?php
}

function slb_save_slb_subscriber_meta( $post_id, $post ) {

  //verify nonce
  if ( !isset( $_POST['slb_subscriber_nonce'] ) || !wp_verify_nonce( $_POST['slb_subscriber_nonce'], basename( __FILE__ ) ) ) {
    return $post_id;
  }

  //get post_type object
  $post_type = get_post_type_object( $post->post_type );

  //check if current user has permission to edit the post
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
    return $post_id;
  }

  //get posted data and sanitize it
  $first_name = ( isset($_POST['slb_first_name']) ) ? sanitize_text_field( $_POST['slb_first_name'] ) : '';
  $last_name = ( isset($_POST['slb_last_name']) ) ? sanitize_text_field( $_POST['slb_last_name'] ) : '';
  $email = ( isset($_POST['slb_email']) ) ? sanitize_text_field( $_POST['slb_email'] ) : '';
  $lists = ( isset($_POST['slb_list']) && is_array($_POST['slb_list']) ) ? (array)$_POST['slb_list'] : [];

  //update post_meta
  update_post_meta( $post_id, 'slb_first_name', $first_name );
  update_post_meta( $post_id, 'slb_last_name', $last_name );
  update_post_meta( $post_id, 'slb_email', $email );

  //delete the existing post meta
  delete_post_meta( $post_id, 'slb_list' );

  if ( !empty( $lists ) ) {
    //add new list meta
    foreach ( $lists as $index=>$list_id ) {
      // add list relational meta value
      add_post_meta( $post_id, 'slb_list', $list_id, false ); //NOT unique meta key
    }
  }
}

add_action('save_post', 'slb_save_slb_subscriber_meta', 10, 2);
