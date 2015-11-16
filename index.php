<?php
if (isset($_GET['c']) && isset($_GET['m'])) {
	require_once "app/controller/{$_GET['c']}.php";
	
	$$_GET['c'] = new $_GET['c']();
	$$_GET['c']->$_GET['m']();
} else {
	require_once 'app/controller/IndexController.php';
	
	$indexController = new IndexController();
	$indexController->index();
}