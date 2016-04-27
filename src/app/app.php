<?php

$app->get('/', function ($request, $response, $args) {
	if (isset($_SESSION['role'])){
		$role = $_SESSION['role'];
	} else {
	    $role = "guest";
	}

	$args['body'] = "login.php";
	$args['role'] = $role;
	if ($role == "user" ) {
		return $response->withStatus(303)->withHeader('Location', '/recommendation');
	} elseif ($role == "admin") {
		return $response->withStatus(303)->withHeader('Location', '/admin');
	} else {
		return $this->renderer->render($response, 'html.php', $args);
	}
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
    
    $this->logger->info("Application /" . $args['body']);

    if(!isset($_SESSION['role'])) {
    	return $response->withStatus(303)->withHeader('Location', '/');
    }


    $args['body'] = $args['body'] . ".php";
    $args['role'] = $_SESSION['role'];

    $params = $request->getQueryParams();

    return $this->renderer->render($response, 'html.php', array_merge($params, $args));
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

	if (!$isActive && $pwdCorrect) {
		$error = "Account is disabled";
	} else {
		$error = "Username or Password Incorrect";
	}

	$url = buildInterstitialURL("Back to Login", "/", $error);
	return $response->withStatus(303)->withHeader('Location', $url);
});

$app->post('/register', function($request, $response, $args) {
	$params = $request->getParsedBody();
	$email = $params["email"];
	$password = $params["password"];

	$data = register($this, $email, $password, "user");

	if ($data['login'] = True) {
		$url = buildInterstitialURL("Back to Login", "/", "Registration Successful");
		session_destroy();
		return $response->withStatus(303)->withHeader('Location', $url);
	} else {
		$this->logger->error("Registration Failed - Email: " . $email);
		$url = buildInterstitialURL("Back to Login", "/", "Registration Failed");
		return $response->withStatus(303)->withHeader('Location', $url);
	}
});

