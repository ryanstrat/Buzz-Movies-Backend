<?php

$app->post('/api/user/register', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];

	$this->logger->debug("email: ". $email);
	$this->logger->debug("password: " . $password);

	$salt = "temp";
	$hash = "temp";

	$query = "INSERT INTO accounts (email, salt, hash) VALUES (?, ? ,?)";
	$SQLparams = array($email, $salt, $hash); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	mysqli_prepared_query($this, $link, $query, "sss", $SQLparams);

	//$query = "INSERT INTO users (account_id) VALUES LAST_INSERT_ID()";
	//mysqli_query($link, $query);



});