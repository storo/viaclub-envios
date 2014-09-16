<?php

if (!defined( 'WP_UNINSTALL_PLUGIN' )){
    exit();
}

require_once 'includes/Migration.php';

$db = new Migration();
$db->delete();
