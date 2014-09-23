<?php

if (!defined( 'WP_UNINSTALL_PLUGIN' )){
    exit();
}

require_once 'includes/Installer.php';

$installerVCE = new Installer();
$installerVCE->uninstall();
