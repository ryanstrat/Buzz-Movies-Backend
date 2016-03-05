<?php

$app->post('/api/user/login', function ($request, $response, $args) {
	//Pass email address and username via post

	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];


	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT id, name, hash FROM accounts WHERE email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);

	$hash = $result[0]["hash"];
	$name = $result[0]['name'];

	if(!password_verify($password, $hash)){
		$this->logger->info("Login Failed - Wrong password: " . $email);
		return $response->withHeader('Content-Type', 'application/json')->write(json_encode(array("login"=>False)));
	}

	$this->logger->info("Login Successful: " . $email);
	$data['login'] = True;
	$data['accountType'] = get_account_type_from_email($this, $email);
	$data['token'] = get_session_key_from_email($this, $email);
	$data['name'] = $name;


	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));

});