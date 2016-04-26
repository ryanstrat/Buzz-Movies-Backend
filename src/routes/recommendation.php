<?php

$app->get('/api/recommendation', function ($request, $response, $args) {
	$this->logger->info("GET /api/recommendation");

	$params = $request->getQueryParams();

	$token = $params['token'];
	$this->logger->info($token);
	$major = get_major_from_key($this, $token);
	$this->logger->info($major);


	$query = "SELECT movie, AVG(stars) as average FROM ratings INNER JOIN users ON ratings.user=users.account_id WHERE users.major=? GROUP BY movie ORDER BY average DESC LIMIT 3";

	$SQLparams = array($major);
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "s", $SQLparams);
	mysqli_close($link);

	$data = $result[0];

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));
});