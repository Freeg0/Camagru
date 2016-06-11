<?php
include 'config/setup.php';

function	minimun_one_digit($char)
{
	$nb = 0;

	while ($char[$nb])
	{
		if (is_numeric($char[$nb]))
			return True;
		$nb = $nb + 1;
	}
	return False;
}

if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']))
{
	$userName = $db->quote($_POST['login']);
	$email = $db->quote($_POST['email']);
	$password = $db->quote(sha1($_POST['password']));

	$data = $db->prepare("SELECT id FROM user WHERE user = :userName OR email = :email");
	$data->execute(Array(
		'userName' => $userName,
		'email' => $email
	));
	if ($data->rowCount() > 0)
	{
		header( "refresh:0.5;url=index.php" );
		$message = "Some user have already use the same username or email";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	else
	{
		if (strcmp($_POST['password'], $_POST['cpassword']) === 0) {
			if (minimun_one_digit($_POST['password']))
			{
				$data = $db->prepare("INSERT INTO user(user,password,email) VALUES(:userName, :password, :email)");
				$data->execute(Array(
					'userName' => $userName,
					'password' => $password,
					'email' => $email
				));	
				mail($_POST['email'], 'Confirmation d\'inscription', 'Vous êtes inscrit sur Camagram!');
				if ($data) {
					header( "refresh:0.5;url=index.php" ); 
					$message = "YOUR REGISTRATION IS COMPLETED...";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}
			}
			else
			{
				header( "refresh:0.5;url=index.php" );
				$message = "Password need to contain minimum one number";
				echo "<script type='text/javascript'>alert('$message');</script>";	
			}
		}
		else {
			header( "refresh:0.5;url=index.php" );
			$message = "SORRY...You have not enter the same password !";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	
	}
}
else
{
	header( "refresh:0.5;url=index.php" );
	$message = "You forgot somethink ?";
	echo "<script type='text/javascript'>alert('$message');</script>";
}
