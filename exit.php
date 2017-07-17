<?php 
	require_once('/config.php');
	if(isset($_SESSION['login']) || isset($_SESSION['email'])) {
		$_SESSION['login'] = null;
		$_SESSION['email'] = null;
	} 
	header("refresh:1;url=index.php");
?>
