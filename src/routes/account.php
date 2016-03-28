<?php

$app->post('/api/account', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$targetAccounts = $params["targetEmails"];
	$targetStatus = $params["targetStatus"];

	$this->logger->info("POST /api/account");
	$this->logger->info("Setting ".count($targetAccounts)." accounts to ".$targetStatus);


	$query = "UPDATE accounts SET status=? WHERE email=?";
	$SQLparams = array_map(function($email, $status) {
		return array($status, $email);
	}, $targetAccounts, array_fill(0, count($targetAccounts), $targetStatus));


	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "ss", $SQLparams);
	mysqli_close($link);

});

$app->get('/api/account', function ($request, $response, $args) {
	$this->logger->info("GET /api/account");

	$query = "SELECT email, name, status FROM accounts";

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query);
	mysqli_close($link);

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($result));
});