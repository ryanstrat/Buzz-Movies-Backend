<?php

$app->post('/api/user/login', function ($request, $response, $args) {
	//Pass email address and username via post

	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];

	$this->logger->debug("email: " . $email);
	$this->logger->debug("password: " . $password);

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT id, hash FROM accounts WHERE email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);

	$hash = $result[0]["hash"];

	if(!password_verify($password, $hash)){
		return $response->withHeader('Content-Type', 'application/json')->write(json_encode(array("login"=>False)));
	}

	$data['login'] = True;
	$data['accountType'] = get_account_type_from_email($this, $email);
	$data['sessionKey'] = get_session_key_from_email($this, $email);


	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));

});