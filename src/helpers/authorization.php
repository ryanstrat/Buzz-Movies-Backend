<?php

function get_account_id_from_email($app, $email) {
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT id FROM accounts WHERE email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);
	
	mysqli_close($link);
	
	return (int) $result[0]["id"];
}

function generate_session_key($app, $email){
	$key = base64_encode(openssl_random_pseudo_bytes(32));

	$accountID = get_account_id_from_email($app, $email);

	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "INSERT INTO `sessions` (`key`, `account_id`) VALUES (?, ?)";
	echo $query;
	$SQLparams = array($key, $accountID);
	$result = mysqli_prepared_query($app, $link, $query, "sd", $SQLparams);
	
	mysqli_close($link);
	
	return $key;
}

function get_account_type_from_email($app, $email){
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT COUNT(*) FROM accounts INNER JOIN users ON accounts.id = users.account_id where email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);

	if ($result[0]["COUNT(*)"] == 1) {
		mysqli_close($link);
		return "user";
	} else {
		$query = "SELECT COUNT(*) FROM accounts INNER JOIN admins ON accounts.id = admins.account_id where email=?";
		$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);
		if ($result[0]["COUNT(*)"] == 1) {
			mysqli_close($link);
			return "admin";
		}
	}
	mysqli_close($link);
	return NULL;
}	

function get_account_type_from_key($app, $sessionKey){
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT account_id FROM sessions where key=?";
	$SQLparams = array($sessionKey);
	$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);
	mysqli_close($link);



	return get_account_type_from_email($email);
}

function get_session_key_from_email($app, $email) {
	$link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	$query = "SELECT `key` FROM `sessions` INNER JOIN `accounts` ON accounts.id = sessions.account_id WHERE email=?";
	$SQLparams = array($email);
	$result = mysqli_prepared_query($app, $link, $query, "s", $SQLparams);
	mysqli_close($link);

	return $result[0]["key"];
}