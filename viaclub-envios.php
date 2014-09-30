<?php
ob_start();
/**
 * Plugin Name: ViaClub Envíos
 * Plugin URI: http://viaclub.cl/
 * Description: ViaClub Envíos Plugin.
 * Version: 0.1
 * Author: Sergio Toro
 * Author URI: http://storo.co/
 * License: Apache
 */

require_once 'includes/constants.php';
require_once 'includes/Installer.php';
require_once 'includes/FormVCE.php';
require_once 'includes/SendVCE.php';

register_activation_hook(__FILE__, 'vce_activation');

function vce_menu(){
    global $submenu;
    add_menu_page('ViaClub Envíos', 'ViaClub Envíos', 'manage_options','vce-list', 'vce_list', 'dashicons-email', 6);
    add_submenu_page( 'vce-list', 'Exportar', 'Exportar', 'manage_options', 'vce-export', 'vce_export' );
    add_submenu_page( 'vce-list', 'Configuración', 'Configuración', 'manage_options', 'vce-options', 'vce_options' );
    # hack change name for auto first sub-menu
    $submenu['vce-list'][0][0] = 'Listado de Envíos';
}

add_action('admin_menu','vce_menu');
add_action('wp_ajax_vce_send', 'vce_ajax_send');

function vce_options(){
    include(VCE_OPTIONS_ADMIN);
}

function vce_list(){
    include(VCE_LIST_ADMIN);
}

function vce_export(){
    include(VCE_EXPORT_ADMIN);
}

function vce_activation(){
    $installerVCE = new Installer();
    $installerVCE->install();
}

function vce_form_send($postID){
    $form = new FormVCE($postID);
    return $form->get();
}

function vce_ajax_send(){
    $send = new SendVCE();

    echo $send->save($_POST['post_id'],
                    $_POST['user_name'],
                    $_POST['user_email'],
                    $_POST['receive_name'],
                    $_POST['receive_email'],
                    $_POST['message'],
                    get_current_user_id());
    die();
}

/*
    // Retrieve The Post's Author ID
    $user_id = get_the_author_meta('ID');
    // Set the image size. Accepts all registered images sizes and array(int, int)
    $size = 'thumbnail';

    // Get the image URL using the author ID and image size params
    $imgURL = get_cupp_meta($user_id, $size);

    // Print the image on the page
    echo '<img src="'. $imgURL .'" alt="">';
 */