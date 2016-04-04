<?php

$app->post('/api/user/register', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];
	$accountType = $params['accountType'];

	$this->logger->info("Register: ". $email);
	//$this->logger->debug("password: " . $password);

	$hash = password_hash($password, PASSWORD_DEFAULT);

	$query = "INSERT INTO accounts (email, hash) VALUES (?,?)";
	$SQLparams = array($email, $hash); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	mysqli_prepared_query($this, $link, $query, "ss", $SQLparams);
	$accountID = mysqli_insert_id($link);

	if ($accountType == "admin") {
		$query = "INSERT INTO admins(account_id) VALUES (" . $accountID . ")";
		mysqli_query($link, $query);
	} else if ($accountType == "user") {
		$query = "INSERT INTO users(account_id) VALUES (" . $accountID . ")";
		mysqli_query($link, $query);
	} else {
		return $response->withStatus(400)->withHeader('Content-Type', 'application/json')->write(json_encode(array("login"=>False, "error"=>"Registration Failed")));
	}

	$sessionKey = generate_session_key($this, $email);
	$jsonResponse = array("token"=>$sessionKey, "accountType"=>$accountType, "login"=>true);
	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($jsonResponse));

});