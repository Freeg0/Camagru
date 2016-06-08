<?php

include 'database.php';

try {

	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$inject = "CREATE DATABASE IF NOT EXISTS DB_CAMAGRU";
	$db->exec($inject);

	$inject = "use DB_CAMAGRU;
					create table user (`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `user` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `email` varchar(255) NOT NULL);
					create table image (`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `user` varchar(255) NOT NULL, `filepath` varchar(255) NOT NULL);";
	$db->exec($inject);

}
catch( PDOException $Exception ) {

	echo $Exception->getMessage();
	die();

}

?>