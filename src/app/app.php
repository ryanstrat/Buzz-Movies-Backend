<?php

$app->get('/', function ($request, $response, $args) {
	if (isset($_SESSION['role'])){
		$role = $_SESSION['role'];
	} else {
	    $role = "guest";
	}

	$args['body'] = "login.php";
	$args['role'] = $role;
	return $this->renderer->render($response, 'html.php', $args);
});

$app->any("/logout", function($request, $response, $args) {
	session_destroy();

	$url = buildInterstitialURL("Continue", "/", "Logout Successful");
	return $response->withStatus(303)->withHeader('Location', $url);
});

$app->get("/interstitial", function($request, $response, $args) {
	$params = $request->getQueryParams();
	$params['body'] = "interstitial.php";

	return $this->renderer->render($response, 'html.php', $params);
});

$app->get('/{body}', function ($request, $response, $args) {
    
    $this->logger->info("Application /" . $args['page']);
    $args['body'] = $args['body'] . ".php";

    return $this->renderer->render($response, 'html.php', $args);
    
});

$app->post('/login', function($request, $response, $args) {
	$params = $request->getParsedBody();
	$email = $params["email"];
	$password = $params["password"];

	$result = login($this, $email, $password);

	$isActive = $result["isActive"];
	$pwdCorrect = $result["pwdCorrect"];
	$name = $result["name"];

	if ($isActive && $pwdCorrect) {
		$role = get_account_type_from_email($this, $email);
		$_SESSION["email"] = $email;
		$_SESSION["name"] = $name;
		$_SESSION["role"] = $role;
		$_SESSION['token'] = get_session_key_from_email($this, $email);

		if ($role == "user") {
			$profile = getUserProfile($this, $email);
			$_SESSION["major"] = $profile["major"];

			return $response->withStatus(303)->withHeader('Location', '/recommendation');
		} elseif ($role == "admin") {
			return $response->withStatus(303)->withHeader('Location', '/admin');
		}
	}

	return $response->withStatus(303)->withHeader('Location', '/admin');
});

