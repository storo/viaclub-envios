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
require_once 'includes/Migration.php';

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
    $db = new Migration();
    $db->create();
}