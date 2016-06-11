<?php

session_start();
include '../config/setup.php';

$_SESSION['photo'] = $_POST['photo'];

// file_put_contents("prout", $_POST['value']);
// file_put_contents("prout2", $_POST['photo']);

list($type, $data) = explode(';', $_POST['photo']);
list(, $data) = explode(',', $data);

$data = str_replace(" ", "+", $data);

$data = base64_decode($data);

if (!file_exists("../img/".$_SESSION['user']))
    	mkdir("../img/".$_SESSION['user']);

file_put_contents("tmp.png", $data);

header ("Content-type: image/png");

// Traitement de l'image source
if ($_POST['value'] === '1')
	$source = imagecreatefrompng("./photo_camagram/cadre1.png");
else if ($_POST['value'] === '2')
	$source = imagecreatefrompng("./photo_camagram/cadre2.png");
else if ($_POST['value'] === '3')
	$source = imagecreatefrompng("./photo_camagram/cadre3.png");
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
imagealphablending($source, true);
imagesavealpha($source, true);
 
// Traitement de l'image destination
$destination = imagecreatefrompng("tmp.png");
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
  
// Calcul des coordonnées pour placer l'image source dans l'image de destination
$destination_x = ($largeur_destination - $largeur_source)/2;
$destination_y =  ($hauteur_destination - $hauteur_source)/2;
  
// On place l'image source dans l'image de destination
//imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);

$nb = 0;

while (file_exists("../img/".$_SESSION['user']."/img".$nb.".png")) {
	$nb = $nb + 1;
}

// file_put_contents("../img/".$_SESSION['user']."/img".$nb.".png", $data);
imagepng($destination, "../img/".$_SESSION['user']."/img".$nb.".png");
imagedestroy($destination);
imagedestroy($source);

$userName = $_SESSION['user'];
$filepath = "../img/".$_SESSION['user']."/img".$nb.".png";

$data = $db->prepare("INSERT INTO image(user,filepath) VALUES(:userName, :filepath)");
$data->execute(Array(
	'userName' => $userName,
	'filepath' => $filepath
));

?>