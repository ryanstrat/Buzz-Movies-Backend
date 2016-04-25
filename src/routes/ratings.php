<?php

$app->post('/api/rating', function ($request, $response, $args) {
	$params = $request->getParsedBody();

	$token = $params['token'];
	$email = get_email_from_key($this, $token);

	$imdbid = $params['imdbid'];
	$stars = $params['stars'];
	$review = $params['review'];

	$this->logger->info("User: ". $email);
	$this->logger->info("imdbid: ". $imdbid);
	$this->logger->info("stars: ". $stars);
	$this->logger->info("review: ". $review);

	if (strlen($imdbid) > 9) {
		//bad input reply with 400:Bad Request
		return $response.withStatus(400);
	}

	$accountID = get_account_id_from_email($this, $email);

	$query = "INSERT INTO ratings(user, movie, stars, review)";
	$query = $query . " VALUES (?, ?, ?, ?)";
	$query = $query . " ON DUPLICATE KEY UPDATE stars=?, review=?";
	$SQLparams = array($accountID, $imdbid, $stars, $review, $stars, $review);

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query, "dsdsds", $SQLparams);
	mysqli_close($link);

	$data['imdbid'] = $imdbid;
	$data['stars'] = $stars;
	$data['review'] = $review;

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($data));

});