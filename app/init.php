<?php
session_start();

spl_autoload_register(function($class){
	require_once 'classes/' .$class. '.php';
});

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Routes.php';

require_once 'functions/sanitize.php';



