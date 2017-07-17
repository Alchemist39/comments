<?php
	session_start();
	$globalSalt = '$5$rounds=1000$128cn91823nc$';
	$host = 'localhost';
	$db   = 'comments';
	$user = 'root';
	$pass = '';
	$charset = 'utf8';
	$dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=' . $charset;
	$pdo = new PDO($dsn, $user, $pass);
?>