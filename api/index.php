<?php
use deckbuilder_archive_php_version_only\api\controller\NavigationController;

session_start();

error_reporting(E_ERROR);
ini_set("display_errors", 1);

include 'src/config/config.php';
require_once __DIR__ . '/vendor/autoload.php'; // falls Sie Composer verwenden

$controller = new NavigationController();
$controller->route();