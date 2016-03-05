<?php

$app->put('/api/user/profile', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$key = $params["sessionKey"];
	$name = $params["name"];
	$major = $params["major"];
	$interests = $params["interests"];

	

});