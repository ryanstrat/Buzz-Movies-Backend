<?php

function addConjunction($text, $position) {
	if($position == 1) {
		return $text." WHERE";
	} else if ($position > 1) {
		return $text." AND";
	} else {
		return;
	}
}

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

	if (strlen($imdbid) != 9) {
		//bad input reply with 400:Bad Request
		return $response->withStatus(400);
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

$app->get('/api/rating', function($request, $response, $args) {
	$this->logger->info("GET /api/rating");

	$params = $request->getQueryParams();

	$query = "SELECT movie, stars, review, email, major FROM ratings INNER JOIN users";
	$query = $query . " ON ratings.user=users.account_id";
	$query = $query . " INNER JOIN accounts ON users.account_id=accounts.id";

	$filters = 0;
	$SQLformat = "";


	if (isset($params['email'])) {
		$email = $params['email'];
		$filters += 1;
		
		$query = addConjunction($query, $filters);

		$query = $query . " email=?";
		$SQLformat = $SQLformat . "s";
		$SQLparams[] = $email;
	}

	if (isset($params['major'])) {
		$major = $params['major'];
		$filters += 1;
		
		$query = addConjunction($query, $filters);

		$query = $query . " major=?";
		$SQLformat = $SQLformat . "s";
		$SQLparams[] = $major;
	}

	if (isset($params['movie'])) {
		$movie = $params['movie'];
		$filters += 1;
		
		$query = addConjunction($query, $filters);

		$query = $query . " movie=?";
		$SQLformat = $SQLformat . "s";
		$SQLparams[] = $movie;
	}

	$this->logger->info("SQL Query: ". $query);
	
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	if ($filters == 0) {
		$result = mysqli_prepared_query($this, $link, $query);
	} else {
		$result = mysqli_prepared_query($this, $link, $query, $SQLformat, $SQLparams);
	}
	mysqli_close($link);

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($result));

});

