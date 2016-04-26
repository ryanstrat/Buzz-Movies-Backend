<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="/js/ajax.js"></script>
        
        <title>Buzz Movies</title>
    </head>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Buzz Movies</a>
            </div>
            <?php


if($role === "guest") {
    $hideLogout = "hidden"; 
} else { 
    $hideLogout = "";
}

            ?>
            <div class="collapse navbar-collapse ">
                <a href="/logout" class="btn btn-default navbar-btn navbar-right <?php echo($hideLogout); ?>">Logout</a>
            </div>

        </div>
    </nav>
    <body>
        <?php include($body); ?>
    </body>
</html>
