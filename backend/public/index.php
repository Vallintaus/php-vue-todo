<?php 
require_once '../vendor/autoload.php';

use Jusa\Backend\Controllers\TaskController;

$controller = new TaskController();
$controller->handleRequest();

