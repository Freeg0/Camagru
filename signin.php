<?php

session_start();
include 'config/setup.php';

if (isset($_POST['submit']))
{
	$password = $db->quote($_POST['password']);
	$userName = $db->quote($_POST['login']);

	if (isset($_POST['login']) && isset($_POST['password']))
	{
		$data = $db->prepare("SELECT id FROM user WHERE user = :userName and password = :password");
		$data->execute(Array(
			'userName' => $userName,
			'password' => $password
		));
		if ($data->rowCount() > 0)
		{
			$_SESSION['loginOK'] = True;
			$_SESSION['user'] = $_POST['login'];
			//You are connected!;
			header('location: mounting_page/index.php');
		}
		else
			header('location: index.php');
	}
}

?>