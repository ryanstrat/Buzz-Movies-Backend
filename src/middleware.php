<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$app->add(function ($request, $response, $next) {
	if (isset($_SESSION['token'])) {
		if ($request->isGet()) {
			$params = $request->getQueryParams();
			$params['token'] = $_SESSION['token'];
			$request = $request->withQueryParams($params);
		} elseif ($request->isPost()) {
			$params = $request->getParsedBody();
			$params['token'] = $_SESSION['token'];
			$request = $request->withParsedBody($params);
		}
	}

	$response = $next($request, $response);

	return $response;
});