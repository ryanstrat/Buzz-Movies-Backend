<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/bootstrap.css" rel="stylesheet">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        
        <title>Buzz Movies</title>
    </head>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Buzz Movies</a>
            </div>
            <?php


if($role != "user") {
    $hideUser = "hidden"; 
} else { 
    $hideUser = "";
}
if($role != "user" && $role != "admin") {
    $hideAll = "hidden"; 
} else { 
    $hideAll = "";
}

            ?>
            <div class="collapse navbar-collapse ">
                <ul class="nav navbar-nav <?php echo($hideUser); ?>">
                    <li><a href="/recommendation">Recommendation</a></li>

                </ul>
                <form class="navbar-form navbar-left <?php echo($hideUser); ?>" role="search" action="movies" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="q" placeholder="Search Movies">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?php echo($hideUser); ?>"><a href="/profile">Profile</a></li>
                    <a href="/logout" class="btn btn-default navbar-btn <?php echo($hideAll); ?>">Logout</a>
                </ul>
            </div>
        </div>
    </nav>
    <body>
        <?php include($body); ?>
    </body>
</html>
