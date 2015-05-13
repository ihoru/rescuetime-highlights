<?php
/**
 * Created by PhpStorm.
 * User: ihoru
 * Date: 5/13/15
 * Time: 11:45 PM
 */

$about = function() {
	$params = [];
	Flight::view()->display('about.html.twig', $params);
};

return $about;
