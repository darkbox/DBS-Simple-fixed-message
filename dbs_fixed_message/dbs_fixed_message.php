<?php
/*
Plugin Name: DBS Simple fixed message
Plugin URI: https://github.com/darkbox/DBS-Simple-fixed-message/
Description: Basic WP plugin for showing a fixed message on all pages.
Version: 1.0
Author: Rafael García
Author URI: https://github.com/darkbox/
License: MIT
*/

// Register settings
function dbs_sfm_register_settings(){
  add_option( 'dbs_sfm_option_message', 'This is my fixed message.');
  add_option( 'dbs_sfm_option_show', '1');

  register_setting( 'dbs_sfm_options_group', 'dbs_sfm_option_message', 'dbs_sfm_callback' );
  register_setting( 'dbs_sfm_options_group', 'dbs_sfm_option_show', 'dbs_sfm_callback' );
}
add_action('admin_init', 'dbs_sfm_register_settings');

// Create options page
function dbs_sfm_register_options_page(){
  add_options_page('Page Title', 'Simple Fixed Message', 'manage_options', 'dbs_sfm', 'dbs_sfm_options_page');
}
add_action('admin_menu', 'dbs_sfm_register_options_page');

// For validation and stuff
function dbs_sfm_callback($input) {
  return $input;
}

// Display settings page
function dbs_sfm_options_page() {  ?>
  <div>
  <h1>Simple fixed message</h1>
  <form method="post" action="options.php">
  <?php settings_fields( 'dbs_sfm_options_group' ); ?>
  <p>This plugin will add a fixed bar at the bottom with a custom message.</p>
    <label for="dbs_sfm_option_show">Show message?</label>
    <input type="checkbox" id="dbs_sfm_option_show" name="dbs_sfm_option_show" value="1" <?php checked(1, get_option('dbs_sfm_option_show'), true); ?>/>
    <label for="dbs_sfm_option_message">Message text</label>
    <input type="text" id="dbs_sfm_option_message" name="dbs_sfm_option_message" value="<?php echo get_option('dbs_sfm_option_message'); ?>" size="100"/>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}

// Insert message in all pages
function dbs_sfm_insert_fixed_message() {
  $show = get_option('dbs_sfm_option_show');
  $message = get_option('dbs_sfm_option_message');
  if ($show == '1') { ?>
  <style media="screen">
      #dbs_fixed_message {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      margin: 0;
      width: 100%;
      font-size: 1em;
      padding: .5em 0;
      text-align: center;
      background: #000;
      color: #fff;
      z-index: 99998;
    }
  </style>
  <p id="dbs_fixed_message"><?php echo $message ?></p>
<?php } // End if
}

// Filters
add_filter ('wp_footer', 'dbs_sfm_insert_fixed_message');

?>
