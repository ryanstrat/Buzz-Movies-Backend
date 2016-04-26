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

include "routes/login.php";

include "routes/register.php";

include "routes/profile.php";

include "routes/account.php";

include "routes/ratings.php";

include "routes/majors.php";