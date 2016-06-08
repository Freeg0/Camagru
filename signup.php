<?php

include 'config/setup.php';

if (isset($_POST['submit']))
{
	$userName = $db->quote($_POST['login']);
	$email = $db->quote($_POST['email']);
	$password = $db->quote($_POST['password']);

	if (strcmp($_POST['password'], $_POST['cpassword']) === 0) {
		$data = $db->prepare("INSERT INTO user(user,password,email) VALUES(:userName, :password, :email)");
		$data->execute(Array(
			'userName' => $userName,
			'password' => $password,
			'email' => $email
		));

		if ($data) {
			echo "YOUR REGISTRATION IS COMPLETED...";
		}
	}
	else {
		echo "SORRY...You have not enter the same password !";
	}
}

// function SignUp() { (!empty($_POST['login'])) //checking the 'user' name which is from Sign-Up.html, is it empty or have some text
// 	{
// 		// $query = $db->query("SELECT * FROM user WHERE user = '$_POST[login]' AND password = '$_POST[password]'") or die($db_errorCode());
// 		// if(!$row = mysql_fetch_array($query) or die(mysql_error())) {
// 		newuser();
// 		// }
// 		// else {
// 			// echo "SORRY...YOU ARE ALREADY REGISTERED USER...";
// 		// }
// 	}
// }

// if (isset($_POST['submit']))
// {
// 	$userName = $_POST['login'];
// 	$email = $_POST['email'];
// 	$password = $_POST['password'];

// 	$request = $db->prepare("INSERT INTO user(user,password,email) VALUES(:userName, :password, :email)");
// 	$request->execute(Array(
// 			'userName' => $userName,
// 			'password' => $password,
// 			'email' => $email
// 		));
// }

?>