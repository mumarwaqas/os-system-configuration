<?php
/**
 * Registration of the Admin dashboard widget
 */
function sc_add_dashboard_widgets() {
    wp_add_dashboard_widget(
      'sc_system_configuration',          // Widget slug
      __('System Configuration (Website URLs)', 'sc-system-configuration'), // Title
      'sc_system_configuration'        // Display function
    );  
}

// hook to register the Admin dashboard widget
add_action( 'wp_dashboard_setup', 'sc_add_dashboard_widgets' );

/**
 * Output the html content of the dashboard widget
 */
function sc_system_configuration() {

  // detect the current user to get his phone number
  $user = wp_get_current_user();
  ?>
  <form id="sc_form" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" >
    <!-- controlls on which function the post will send -->
    <input type="hidden" name="sc_action" id="sc_action" value="sc_user_data">
    <?php wp_nonce_field( 'sc_nonce', 'sc_nonce_field' ); ?>
    <div class="input-text-wrap" id="home-wrap">
        <label for="home">Home Url:</label>
        <input type="text" name="home" id="home" value="<?php echo esc_attr(get_option('home')); ?>" class="regular-text">
      </div>

    <div class="input-text-wrap" id="siteurl-wrap">
        <label for="siteurl">Site Url:</label>
        <input type="text" name="siteurl" id="siteurl" value="<?php echo esc_attr(get_option('siteurl')); ?>" class="regular-text">
    </div>
    <div class="input-text-wrap" id="api-wrap">
        <label for="api_url">Api Url:</label>
        <input type="text" name="api_url" id="api_url" value="<?php echo esc_attr(get_option('api_url')); ?>" class="regular-text">
    </div>
    <p>
      <input name="save-data" id="save-data" class="button button-primary" value="Save Settings" type="submit"> 
      <a id="message" style="margin-left: 10px;"></a>
      <br class="clear">
    </p>
  </form>
<?php
}
/**
 * Saves the data from the admin widget
 */
function sc_save_user_data() {
    $msg = '';
    if(array_key_exists('nonce', $_POST) AND  wp_verify_nonce( $_POST['nonce'], 'sc_nonce' ) ) 
    {
       // detect the current user to get his phone number
       $user = wp_get_current_user();

       // change the phone number
       update_option( 'home',     $_POST['home'] );
       update_option( 'siteurl',  $_POST['siteurl'] );
       update_option( 'api_url',  $_POST['api_url'] );

       // success message
       $msg = 'Settings Saved';
    }
    else
    {   
      // error message
      $msg = 'Settings unsaved';
    }
    wp_send_json( $msg );
}

/**
 * ajax hook for registered users
 */
 add_action( 'wp_ajax_sc_user_data', 'sc_save_user_data' );

