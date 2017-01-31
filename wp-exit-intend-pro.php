<?php
/*
    Plugin Name: WP Exit Intent Pro
    Description: Exit-intent technology provides you a powerful and simple way to convert more visitors to buyers and build your email subscription list. This Plugin helps you increase landing page conversion rates.
    Plugin URI: 
    Author: Michel Moraes
    Author URI: http://michelmoraes.com
    Version: 1.0.0
    Tested up to: 4.7.1
    License: GPL2
    License URI: https://www.gnu.org/licenses/gpl-2.0.html
    Text Domain: wp-exit-intent
*/

//======================================================================
//      CONSTANTS
//======================================================================

    define('WPEI_FILE', __FILE__);
    define('WPEI_ROOT', dirname(__FILE__));

if ( !defined( 'WPEI_PATH' ) )
    define( 'WPEI_PATH', plugin_dir_path( __FILE__ ) );


//======================================================================
//      TITAN FRAMEWORK
//======================================================================

require_once( 'titan-framework/titan-framework-embedder.php' );

add_action( 'tf_create_options', 'wpei_create_options' );
function wpei_create_options() {

    // Initialize Titan with my special unique namespace
    $titan = TitanFramework::getInstance( 'wpei' );

    // Create my admin panel
    $adminPanel = $titan->createAdminPanel( array(
        'name'  => 'Exit Intent Pro',
        'icon'  =>  'dashicons-laptop'
        ) );

    // Create First Tab
    $globalTab = $adminPanel->createTab( array(
    'name' => 'Global',
    ) );

    // Create options inside the First Tab
    $globalTab->createOption( array(
        'name' => 'Aggressive mode',
        'id' => 'is_aggresive',
        'type' => 'enable',
        'default' => false,
        'desc' => "By default, ExitIntentPro will only fire once for each visitor. When ExitIntentPro fires, a cookie is created to ensure a non obtrusive experience.<br>There are cases, however, when you may want to be more aggressive (as in, you want the modal to be elegible to fire anytime the page is loaded/ reloaded). An example use-case might be on your paid landing pages. If you enable aggressive, the modal will fire any time the page is reloaded, for the same user.",
    ) );
    $globalTab->createOption( array(
        'name' => 'Timer',
        'id' => 'timer',
        'type' => 'number',
        'max'   =>  '10000',
        'step'     => '500',
        'size'  => 'medium',
        'unit'      =>  'ms',        
        'desc' => "By default, ExitIntentPro won't fire in the first second to prevent false positives, as it's unlikely the user will be able to exit the page within less than a second. If you want to change the amount of time that firing is surpressed for, you can pass in a number of milliseconds to timer."
        ) );
    $globalTab->createOption( array(
        'name' => 'Delay',
        'id' => 'delay',
        'type' => 'number',
        'max'   =>  '10000',
        'size'  => 'medium',        
        'step'     => '500',
        'unit'      =>  'ms',
        'desc' => "By default, ExitIntentPro will show the modal immediately. You could instead configure it to wait x milliseconds before showing the modal. If the user's mouse re-enters the body before delay ms have passed, the modal will not appear. This can be used to provide a 'grace period' for visitors instead of immediately presenting the modal window."
        ) );  


    // Create Second Tab
    $contentTab = $adminPanel->createTab( array(
        'name' => 'Content',
    ) );    
    $contentTab->createOption( array(
        'name'      => "Custom HTML",
        // 'name'      => "Custom HTML<br><br><small><a href='#'>Click here</a> to see the documentation.</small>",        
        'id'        => 'wpei_custom_html',
        'type'      => 'textarea',
        'is_code'    => true
        ) );    


    // Create Third Tab
    $styleTab = $adminPanel->createTab( array(
    'name' => 'Style',
    ) );

    $styleTab->createOption( array(
        'name' => 'Default Modal',
        'type' => 'heading',
        'desc'  =>  'Styling the default modal'           
    ) );    

    // Create options inside the Second Tab
    $styleTab->createOption( array(
        'name' => 'Header Background Color',
        'id' => 'modal_header_bg_color',
        'type' => 'color',
        'desc' => 'Choose a background color',
        'default' => '#555555'
        ) );
    $styleTab->createOption( array(
        'name' => 'Header Font Color',
        'id' => 'modal_header_font_color',
        'type' => 'color',
        'desc' => 'Choose a font color',
        'default' => '#ffffff'
        ) );
    $styleTab->createOption( array(
        'name' => 'Body Background Color',
        'id' => 'modal_body_bg_color',
        'type' => 'color',
        'desc' => 'Choose a font color',
        'default' => '#f0f1f2'
        ) ); 
    $styleTab->createOption( array(
        'name' => 'Body Font Color',
        'id' => 'modal_body_font_color',
        'type' => 'color',
        'desc' => 'Choose a font color',
        'default' => '#344a5f'
        ) );        
    $styleTab->createOption( array(
        'name' => 'Custom Modal',
        'type' => 'heading',
        'desc'  =>  'Using this fields below overrides the default style'        
    ) );      
    $styleTab->createOption( array(
        'name'  => 'Custom CSS',
        'id'    => 'wpei_custom_css',
        'type'  => 'code',
        'lang'  => 'css',
        'theme' =>  'monokai'
        ) );
     $titan->createCSS( ' 
        #ouibounce-modal .wpei-modal-title { 
            background-color: $modal_header_bg_color; 
        }
        #ouibounce-modal .wpei-modal-title h3 { 
            color: $modal_header_font_color;
        } 
        #ouibounce-modal .wpei-modal { 
            background-color: $modal_body_bg_color;
        }
        #ouibounce-modal p { 
            color: $modal_body_font_color;
        }
        #ouibounce-modal .wpei-modal-footer p {
            border-bottom-color: $modal_body_font_color;
        }

    ' );

    // create submit button
    $adminPanel->createOption( array(
        'type' => 'save'
        ) );

}


//======================================================================
//      CLASSES
//======================================================================

require_once( WPEI_PATH . '/class-optin-form.php' );
$optin_form = new Optin_Form();
add_action( 'wp_footer', array( $optin_form, 'render' ) );


//======================================================================
//      INCLUDES
//======================================================================

function enqueue_ouibounce_scripts() {
    wp_enqueue_script( 'ouibounce',  plugins_url( '/js/ouibounce.js' , WPEI_FILE ), array() );
    wp_enqueue_script( 'ouibounce-config',  plugins_url( '/js/ouibounce-config.js' , WPEI_FILE ), array( 'jquery' ) );

            $titan = TitanFramework::getInstance( 'wpei' );
            $opt_is_agressive = $titan->getOption( 'is_aggresive' );
            $opt_timer = $titan->getOption( 'timer' );
            $opt_delay = $titan->getOption( 'delay' );

    wp_localize_script(
        'ouibounce-config', 'wpeiVars', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'ouibounce' ),
            'opt_is_agressive' => $opt_is_agressive,
            'opt_timer' => $opt_timer,
            'opt_delay' => $opt_delay

        )
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_ouibounce_scripts' );    

wp_register_style('wpei-modal', plugins_url('/css/modal.css', WPEI_FILE ));
wp_enqueue_style('wpei-modal');



