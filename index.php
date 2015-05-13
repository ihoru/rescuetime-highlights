<?php
/**
 * Created by PhpStorm.
 * User: ihoru
 * Date: 5/13/15
 * Time: 11:37 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('BASE_DIR', dirname(__FILE__).'/');

if (!file_exists(BASE_DIR.'vendor/autoload.php')) {
	die('Run: composer install');
}

if (!file_exists(BASE_DIR.'config.php')) {
	die('Create config.php file');
}

require_once(BASE_DIR.'vendor/autoload.php');
require_once(BASE_DIR.'config.php');

Flight::set('flight.log_errors', true);

$loader = new Twig_Loader_Filesystem(BASE_DIR.'templates');
$twigConfig = array(
	// 'cache'	=>	'./cache/twig/',
	// 'cache'	=>	false,
	'debug' => true,
);
Flight::register('view', 'Twig_Environment', array($loader, $twigConfig), function (Twig_Environment $twig) {
	$twig->addExtension(new Twig_Extension_Debug());
	$twig->addGlobal('base_url', rtrim(dirname($_SERVER['REQUEST_URI']), '/').'/');
	return $twig;
});

Flight::route('/', include(BASE_DIR.'routes/home.php'));
Flight::route('/about', include(BASE_DIR.'routes/about.php'));
Flight::map('notFound', function(){
	Flight::redirect('/');
});

Flight::start();
