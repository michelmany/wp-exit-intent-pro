<?php

class Optin_Form {

  public function __construct() {
    add_action( 'wp_ajax_process_optin_submission', array( $this, 'process' ) );
    add_action( 'wp_ajax_nopriv_process_optin_submission', array( $this, 'process' ) );
  }

  public function process() {
    if( ! wp_verify_nonce( $_POST['nonce'], 'ouibounce' ) )
      return;

    $data = array(
      'email' => $_POST['email']
    );

    $curl = curl_init();
    curl_setopt_array( $curl, array(
      CURLOPT_HTTPHEADER => array( 'Content-Type: application/json', 'Accept: application/json' ), // -H parameter
      CURLOPT_RETURNTRANSFER => 1, // so that we can catch the response in a variable
      CURLOPT_URL => 'http://reqr.es/api/users', // The endpoint
      CURLOPT_POST => 1, // -X POST
      CURLOPT_USERPWD =>  'app_id:api_key', // -u parameter (not always needed)
      CURLOPT_POSTFIELDS => json_encode( $data ) // because we set Content-Type to JSON
    ) );

    $resp = curl_exec( $curl );
    curl_close( $curl );
    print_r( $resp );
    wp_die();

  }

  public function render() { ?>

<?php 
    $titan = TitanFramework::getInstance( 'wpei' );
    $wpei_custom_html = $titan->getOption( 'wpei_custom_html' );
?>

    <!-- OuiBounce Modal -->
    <div id="ouibounce-modal">
        <div class="underlay"></div>
        <div class="wpei-modal">
            <?php if ($wpei_custom_html) : ?>
                <?php echo do_shortcode($wpei_custom_html); ?>
                <?php else: ?>
                    <div class="wpei-modal-title">
                        <h3>This is a Modal Demo!</h3>
                    </div>
                    <div class="wpei-modal-body">
                        <p>Thanks for using the WP Exit Intent Pro!</p>
                    </div>
                    <div class="wpei-modal-footer">
                        <p>Close</p>
                    </div>                    
               <?php endif ?>
        </div>
    </div>

    
    <?php
  }
}
