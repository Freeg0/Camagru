<?php

include '../config/setup.php';

session_start();

$f = $_SESSION['path'];
$user = $_SESSION['user'];

$dt = $db->prepare("SELECT id FROM `like` WHERE user = :user");
$dt->execute(Array('user' => $user));

if ($dt->rowCount() > 0) {
	header('location: picture_page.php');
}
else {
	if (isset($_POST['submit'])) {
		$data = $db->prepare("INSERT INTO `like` (user,filepathimage) VALUES(:user, :f)");
		$data->execute(Array(
			'user' => $user,
			'f' => $f
		));
	}

	header('location: picture_page.php');
}
?>