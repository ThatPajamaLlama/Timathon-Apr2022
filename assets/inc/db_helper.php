<?php

function db_connect(){
	if (file_exists('assets/db.ini')){
		$credentials = parse_ini_file('assets/db.ini');
	} else {
		$credentials = parse_ini_file('../db.ini');
	}

	$conn = mysqli_connect("localhost", $credentials['username'], $credentials['password'], $credentials['dbname']);

	if (!$conn){
		$log = date("d-m-Y, h:i a") . PHP_EOL . "Error type: Connection" . PHP_EOL . "Error: " . mysqli_connect_error() . PHP_EOL . PHP_EOL;
		file_put_contents('assets/log.txt', $log, FILE_APPEND);
		header('Location: error.php?r=db');
		die();
	}

	return $conn;
}

function db_query($conn, $sql){
	$result = mysqli_query($conn, $sql);

	if (!$result){
		$log = date("d-m-Y, h:i a") . PHP_EOL .
			   "Error type: SQL" . PHP_EOL .
			   "SQL: " . $sql . PHP_EOL .
			   "Error: " . mysqli_error($conn) . PHP_EOL . PHP_EOL;

		if (file_exists('assets/log.txt')){
			file_put_contents('assets/log.txt', $log,FILE_APPEND);
		} else {
			file_put_contents('../log.txt', $log, FILE_APPEND);
		}

		header('Location: error.php?r=db');
		die();
	}

	return $result;
}

function db_prep_stmt($conn, $sql, $values){
	$param_type = '';
	$num_values = count($values);
	for ($i = 0; $i < $num_values; $i++){
		$param_type .= $values[$i][0];
	}

	$parameters = array();
	$parameters[] = & $param_type;

	for ($i = 0; $i < $num_values; $i++){
		$parameters[] = & $values[$i][1];
	}

	$stmt = mysqli_prepare($conn, $sql);
	call_user_func_array(array($stmt, 'bind_param'), $parameters);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	return $result;

	/* EXAMPLE USAGE
			$values = [
					['s', 'shannon'],
					['s', 'password']
			];
			$users = db_prep_stmt($conn, "SELECT * FROM user WHERE username = ? AND password = ?", $values);
	*/
}

function db_input($conn, $name, $method){
	switch ($method){
		case "get":
			$value = (isset($_GET[$name]) ? mysqli_real_escape_string($conn, $_GET[$name]) : "");
			break;
		case "post":
			$value = (isset($_POST[$name]) ? mysqli_real_escape_string($conn, $_POST[$name]) : "");
			break;
		case "session":
			$value = (isset($_SESSION[$name]) ? mysqli_real_escape_string($conn, $_SESSION[$name]) : "");
			break;
	}
	return $value;
}