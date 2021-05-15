<?php

/**
*Plugin Name: slido
*Description: slide everything with grid
*Version: 0.1
*Author: enzo corvaglia
*/

/**
 * Include CSS file for MyPlugin.
 */
function enqueue_slido_scripts() {
    wp_register_style( 'slido-style',  plugin_dir_url( __FILE__ ) . 'slido-style.css' );
    wp_enqueue_style( 'slido-style' );
}
add_action( 'wp_head', 'enqueue_slido_scripts' );



//include "libreria.php";	
include "slido-class.php";

include 'slido.php'; 


