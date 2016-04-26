<?php

$app->get('/api/majors', function ($request, $response, $args) {
	$this->logger->info("GET /api/majors");

	$query = "SELECT * FROM majors ORDER BY major";

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($this, $link, $query);
	mysqli_close($link);

	return $response->withHeader('Content-Type', 'application/json')->write(json_encode($result));
});