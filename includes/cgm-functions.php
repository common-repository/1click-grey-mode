<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
 * Add plugin menu to the Admin Control Panel
 */
 
  
add_action('admin_menu', 'cgm_admin_page');
function cgm_admin_page(){
    add_menu_page('1Click Grey Mode', '1Click Grey Mode', 'administrator', 'cgm-grey-settings', 'cgm_admin_page_callback');
}

/*
 * Register the settings
 */
add_action('admin_init', 'cgm_register_settings');
function cgm_register_settings(){
    //this will save the option in the wp_options table as 'cgm_settings'
    //the third parameter is a function that will validate your input values
    register_setting('cgm_settings', 'cgm_settings',  'cgm_sanitize' );
  
}

/**
 * Sanitization callback
 *
 * @since 1.0.0
 */
function cgm_sanitize( $options ) {

    // If we have options lets cgm_sanitize them
    if ( $options ) {

        // Checkbox
        if ( ! empty( $options['grey_mode'] ) ) {
            $options['grey_mode'] = 'on';
        } else {
            unset( $options['grey_mode'] ); // Remove from options if not checked
        }

        // Input
        if ( ! empty( $options['grey_level'] ) ) {
            $options['grey_level'] = cgm_sanitize_text_field( $options['grey_level'] );
        } else {
            unset( $options['grey_level'] ); // Remove from options if empty
        }

    }

    // Return cgm_sanitized options
    return $options;

}

/**
 * Returns all theme options
 *
 * @since 1.0.0
 */
 function cgm_get_grey_options() {
    return get_option( 'cgm_settings' );
}

/**
 * Returns single theme option
 *
 * @since 1.0.0
 */
 function cgm_get_grey_option( $id ) {
    $options = cgm_get_grey_options();
    if ( isset( $options[$id] ) ) {
        return $options[$id];
    }
}

//The markup for your plugin settings page
function cgm_admin_page_callback(){ ?>
    <div class="wrap">
    <h2>1Click Grey Mode Settings</h2>
    <p>Enabling Grey Mode will turn all your website into grey scale</p>
    <form action="options.php" method="post"><?php
        settings_fields( 'cgm_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'cgm_settings' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">Enable Grey Mode</th>
                <td>
                    <fieldset>
                        <label>
                            <?php  $value = cgm_get_grey_option( 'grey_mode' );?>
                        <input type="checkbox" id="grey_mode" name="cgm_settings[grey_mode]" <?php checked( $value, 'on' ); ?> > 
                        
                        </label>
                        
                    </fieldset>
                </td>
            </tr>

           
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<?php }


function cgm_get_setting( $id = '' ) {
	return cgm_get_grey_option( $id );
}

$mode  = cgm_get_setting('grey_mode');
if($mode == 'on')
{
    add_filter( 'body_class','cgm_add_grey_class' );
}
else
{
    add_filter( 'body_class','cgm_remove_grey_class' );
}

function cgm_add_grey_class($classes) {
    $classes[] = 'grey-mode';
     
    return $classes;
}

function cgm_remove_grey_class($classes) {
    return array();
}