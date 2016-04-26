<?php

function getUserProfile($app, $email) {
	$query = "SELECT name, major, interests FROM accounts INNER JOIN users ON accounts.id=users.account_id WHERE email=?";
	$SQLparams = array($email); 

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);
	mysqli_close($link);

	//var_dump($result);
	return $result[0]; //protection again extra db matches
}