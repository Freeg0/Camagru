<?php

session_start();

include '../config/setup.php';

function number_of_char($com) {
	$nb = 0;

	while ($com[$nb] || $com[$nb] === '0') {
		$nb = $nb + 1;
	}
	return $nb;
}

$user = $_SESSION['user'];
$f = $_SESSION['path'];
$com = $_POST['commentaire'];

$nb_char = number_of_char($com);
file_put_contents("prout1", $nb_char);
if ($nb_char > 150) {
	header( "refresh:0.5;url=picture_page.php" );
	$message = "Your message have more than 150 character!";
	echo "<script type='text/javascript'>alert('$message');</script>";
}
if ($com !== '')
{
	$co = $db->prepare("INSERT comments(user,filepathimage,comment) VALUES(:user, :f, :com)");
	$co->execute(Array(
		'user' => $user,
		'f' => $f,
		'com' => $com
	));
	$path1 = explode("/", $_SESSION['path']);
	$path2 = $path1[4];
	$em = $db->prepare("SELECT email FROM user WHERE id = 1");
	$em->execute();
	$result = $em->fetch();
	$email = explode("'", $result[0]);
	mail($email[1], 'New comment', $_SESSION['user'].' sended a new comment on your pictures!');
}

header('location: picture_page.php');

?>