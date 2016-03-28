<?php

$app->post('/api/account', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$email = $params["email"];
	$status = $params["status"];

	$this->logger->info("POST /api/account");
	$this->logger->info("Setting ".$email." to ".$status);


	$query = "UPDATE accounts SET status=? WHERE email=?";
	$SQLparams = array($status, $email);


	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "ss", $SQLparams);
	mysqli_close($link);

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode(array("status"=>$status)));

});

$app->get('/api/account', function ($request, $response, $args) {
	$this->logger->info("GET /api/account");

	$query = "SELECT email, name, status FROM accounts";

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query);
	mysqli_close($link);

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($result));
});