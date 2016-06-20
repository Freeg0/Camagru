<?php

include '../config/setup.php';

$f = explode('-', $_POST['submit']);
$file = $f[0];

$data = $db->prepare("DELETE FROM image WHERE filepath = :file");
$data->execute(Array(
	'file' => $file
));

header('location: index.php');
unlink($file);

?>