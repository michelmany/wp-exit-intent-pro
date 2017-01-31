
add_action( 'admin_menu', 'wpei_add_admin_menu' );
add_action( 'admin_init', 'wpei_settings_init' );


function wpei_add_admin_menu(  ) { 

    add_menu_page( 'WP Exit Intent Pro', 'Exit Intent', 'manage_options', 'wp_exit_intent_pro', 'wpei_options_page', 'dashicons-laptop' );

}


function wpei_settings_init(  ) { 

    register_setting( 'pluginPage', 'wpei_settings' );

    add_settings_section(
        'wpei_pluginPage_section', 
        __( 'Settings', 'wp-exit-intent' ), 
        'wpei_settings_section_callback', 
        'pluginPage'
    );

    add_settings_field( 
        'wpei_radio_field_0', 
        __( 'Settings field description', 'wp-exit-intent' ), 
        'wpei_radio_field_0_render', 
        'pluginPage', 
        'wpei_pluginPage_section' 
    );

    add_settings_field( 
        'wpei_textarea_field_1', 
        __( 'Settings field description', 'wp-exit-intent' ), 
        'wpei_textarea_field_1_render', 
        'pluginPage', 
        'wpei_pluginPage_section' 
    );

    add_settings_field( 
        'wpei_select_field_2', 
        __( 'Settings field description', 'wp-exit-intent' ), 
        'wpei_select_field_2_render', 
        'pluginPage', 
        'wpei_pluginPage_section' 
    );

    add_settings_field( 
        'wpei_text_field_3', 
        __( 'Settings field description', 'wp-exit-intent' ), 
        'wpei_text_field_3_render', 
        'pluginPage', 
        'wpei_pluginPage_section' 
    );

    add_settings_field( 
        'wpei_text_field_4', 
        __( 'Settings field description', 'wp-exit-intent' ), 
        'wpei_text_field_4_render', 
        'pluginPage', 
        'wpei_pluginPage_section' 
    );


}


function wpei_radio_field_0_render(  ) { 

    $options = get_option( 'wpei_settings' );
    ?>
    <input type='radio' name='wpei_settings[wpei_radio_field_0]' <?php checked( $options['wpei_radio_field_0'], 1 ); ?> value='1'>
    <?php

}


function wpei_textarea_field_1_render(  ) { 

    $options = get_option( 'wpei_settings' );
    ?>
    <textarea cols='40' rows='5' name='wpei_settings[wpei_textarea_field_1]'> 
        <?php echo $options['wpei_textarea_field_1']; ?>
    </textarea>
    <?php

}


function wpei_select_field_2_render(  ) { 

    $options = get_option( 'wpei_settings' );
    ?>
    <select name='wpei_settings[wpei_select_field_2]'>
        <option value='1' <?php selected( $options['wpei_select_field_2'], 1 ); ?>>Option 1</option>
        <option value='2' <?php selected( $options['wpei_select_field_2'], 2 ); ?>>Option 2</option>
    </select>

<?php

}


function wpei_text_field_3_render(  ) { 

    $options = get_option( 'wpei_settings' );
    ?>
    <input type='text' name='wpei_settings[wpei_text_field_3]' value='<?php echo $options['wpei_text_field_3']; ?>'>
    <?php

}


function wpei_text_field_4_render(  ) { 

    $options = get_option( 'wpei_settings' );
    ?>
    <input type='text' name='wpei_settings[wpei_text_field_4]' value='<?php echo $options['wpei_text_field_4']; ?>'>
    <?php

}


function wpei_settings_section_callback(  ) { 

    echo __( 'This section description', 'wp-exit-intent' );

}


function wpei_options_page(  ) { 

    ?>
    <form action='options.php' method='post'>

        <h2>WP Exit Intent Pro</h2>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}

