<?php
// Routes

/*
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

*/

$app->post('/api/user/login', function ($request, $response, $args) {
	//Pass email address and username via post

	$params = $request->getParsedBody();

	$email = $params["email"];
	$password = $params["password"];

	$this->logger->debug("email: " . $email);
	$this->logger->debug("password: " . $password);


	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

	if ($mysqli->connect_errno) {
	    $this->logger->error( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
	    exit();
	}
	if (!($stmt = $mysqli->prepare("SELECT id, salt, hash FROM users WHERE email=(?)"))) {
	    $this->logger->error("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
	    exit();
	}

	$stmt->bind_param("s", $email);

	if (!$stmt->execute()) {
	    $this->logger->error("Execute failed: (" . $mysqli->errno . ") " . $mysqli->error);
	    exit();
	}
	if (!($res = $stmt->get_result())) {
	    $this->logger->error("Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
	    exit();
	}

	$row = $res->fetch_assoc();
	
	if (count($row) > 0) {
		$login = TRUE;
	} else {
		$login = FALSE;
	}

	$this->logger->debug(count($row));

	if ($login) {
		echo json_encode(array("login" => TRUE, "sessionKey" => "01234567890123456789012345678901")); //TODO: Replace with cryptographic pseudorandom number generator
	} else {
		echo json_encode(array("login" => FALSE));
	}

});

//$app->post('/api/user/register')