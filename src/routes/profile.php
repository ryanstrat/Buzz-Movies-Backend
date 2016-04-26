<?php

$app->post('/api/user', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$token = $params["token"];
	$name = $params["name"];
	$major = $params["major"];
	$interests = $params["interests"];

	$this->logger->info("POST /api/user");
	$this->logger->info("token: ".$token);
	$this->logger->info("name: ".$name);
	

	$email = get_email_from_key($this, $token);

	$this->logger->info("email: ".$email);

	$query = "UPDATE accounts INNER JOIN users ON accounts.id=users.account_id SET name=?, major=?, interests=? WHERE email=?";
	$SQLparams = array($name, $major, $interests, $email); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "ssss", $SQLparams);
	mysqli_close($link);
	
	$data['name'] = $name;
	$data['major'] = $major;
	$data['interests'] = $interests;
	$data['token'] = $token;

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));
});

$app->get('/api/user', function ($request, $response, $args) {
	$params = $request->getQueryParams();

	$token = $params['token'];
	$email = get_email_from_key($this, $token);

	$this->logger->info("GET /api/user");
	$this->logger->info("email: ".$email);

	$data = getUserProfile($this, $email);
	
	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));
});