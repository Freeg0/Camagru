<?php

include 'config/setup.php';

$email = $db->quote($_POST['email']);
$password = $db->quote(sha1($_POST['password']));

if ($_POST['email'] !== '' && $_POST['password'] !== '' && $_POST['cpassword'] !== '')
{
	if (strcmp($_POST['password'], $_POST['cpassword']) === 0)
	{
		$data = $db->prepare("UPDATE user SET password=:password WHERE email=:email");
		$data->execute(Array(
			'email' => $email,
			'password' => $password
		));
		mail($_POST['email'], 'Reset Password', 'Your password have change with success !');
		header( "refresh:0.5;url=index.php" );
		$message = "Your password have change with success !";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
}
else
{
	header( "refresh:0.5;url=index.php" ); 
	$message = "An error occurred.";
	echo "<script type='text/javascript'>alert('$message');</script>";
}

?>