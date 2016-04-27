<?php

$app->post('/api/user/register', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];
	$accountType = $params['accountType'];

	$this->logger->info("Register: ". $email);
	//$this->logger->debug("password: " . $password);
	$data = register($this, $email, $password, $accountType);
	
	if ($data['login'] == true) {
		$statusCode = 200;
	} else {
		$statusCode = 400;
	}

	return $response->withJson($data);

});