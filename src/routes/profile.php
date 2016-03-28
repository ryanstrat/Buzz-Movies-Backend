<?php

$app->post('/api/user', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$key = $params["token"];
	$name = $params["name"];
	$major = $params["major"];
	$interests = $params["interests"];

	$this->logger->info("POST /api/user");
	$this->logger->info("token: ".$key);
	$this->logger->info("name: ".$name);
	

	$email = get_email_from_key($this, $key);

	$this->logger->info("email: ".$email);

	$query = "UPDATE accounts INNER JOIN users ON accounts.id=users.account_id SET name=?, major=?, interests=? WHERE email=?";
	$SQLparams = array($name, $major, $interests, $email); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "ssss", $SQLparams);
	mysqli_close($link);
	var_dump($result);

});

$app->get('/api/user', function ($request, $response, $args) {
	$params = $request->getQueryParams();

	$email = $params['email'];

	$this->logger->info("GET /api/user");
	$this->logger->info("email: ".$email);

	$query = "SELECT name, major, interests FROM accounts INNER JOIN users ON accounts.id=users.account_id WHERE email=?";
	$SQLparams = array($email); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);
	mysqli_close($link);

	$data = $result[0]; //protection again extra db matches
	//var_dump($result);
	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));
});