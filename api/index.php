<?php
use deckbuilder_archive_php_version_only\api\controller\NavigationController;

error_reporting(E_ERROR);
ini_set("display_errors", 1);

require_once __DIR__ . '/vendor/autoload.php'; // falls Sie Composer verwenden

$controller = new NavigationController();
$controller->route();