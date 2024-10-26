<?php
/*
Plugin Name: 1Click Grey Mode 
Description: Plugin for Grey Mode
Version:     1.0
Author: Eng. Hanan Abu Kwaider
Author URI:  https://www.linkedin.com/in/hananabukwaider/
License: GPLv2 
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__) . 'includes/cgm-functions.php';


// remove plugin stylesheet on plugin deactivate
function dequeue_cgm_css() {
    wp_dequeue_style('CGMstyle');
    wp_deregister_style('CGMstyle');
  }
 register_deactivation_hook( __FILE__, 'dequeue_cgm_css' );


// load plugin stylesheet
function load_cgm_stylesheets()
{

    wp_register_style('CGMstyle',plugin_dir_url(__FILE__). 'css/cgm-style.css',array(),false,'all');
    wp_enqueue_style( 'CGMstyle' );

}
add_action( 'wp_enqueue_scripts','load_cgm_stylesheets');



