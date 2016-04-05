<?php

$app->post('/api/user/login', function ($request, $response, $args) {
	//Pass email address and username via post

	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];


	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT id, name, hash, status FROM accounts WHERE email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);

	$hash = $result[0]["hash"];
	$name = $result[0]['name'];
	$status = $result[0]['status'];

	$isActive = 0 == strcmp($status, 'active');
	$pwdCorrect = password_verify($password, $hash);

	if (!$isActive || !$pwdCorrect) {
		$this->logger->info("Login Failed: " . $email);
		$data['login'] = False;

		if (!$isActive) {
			$data['error'] = "Login Failed - Account not active";
			$this->logger->info("Login Failed - Account status: ".$status);
		}

		if (!$pwdCorrect) {
			$data['error'] = "Login Failed - Wrong Password";
			$this->logger->info("Login Failed - Wrong password");
		}

		return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));
	}

	$accountType = get_account_type_from_email($this, $email);

	if ($accountType == "user") {
		$query = "SELECT major, interests FROM accounts INNER JOIN users ON accounts.id=users.account_id WHERE email=?";
		$SQLparams = array($email); 

		$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
		$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);
		mysqli_close($link);

		$major = $result[0]['major']; //protection again extra db matches
		$interests = $result[0]['interests'];

		$data['major'] = $major;
		$data['interests'] = $interests;
	}

	$this->logger->info("Login Successful: " . $email);
	$data['login'] = True;
	$data['accountType'] = $accountType;
	$data['token'] = get_session_key_from_email($this, $email);
	$data['name'] = $name;
	$data['status'] = $status;
	

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));

});