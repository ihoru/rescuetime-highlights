<?php
/**
 * Created by PhpStorm.
 * User: ihoru
 * Date: 5/13/15
 * Time: 11:44 PM
 */

$home = function() {
	global $LABELS;
	$params = [];
	$request = Flight::request();
	if ($request->data->label) {
		$message = $request->data->message ?: date('H:i');
		$post_data = http_build_query([
			'key' => RT_API_KEY,
			'highlight_date' => date('Y-m-d'),
			'description' => $message,
			'source' => $request->data->label,
		]);
		$opts = ['http' => [
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $post_data,
		]];
		$context = stream_context_create($opts);
		$result = file_get_contents('https://www.rescuetime.com/anapi/highlights_post', false, $context);
		$params['result'] = $result;
	}
	$params['labels'] = $LABELS;
	Flight::view()->display('home.html.twig', $params);
};

return $home;
