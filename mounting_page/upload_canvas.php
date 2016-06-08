<?php

session_start();
include '../config/setup.php';

$_SESSION['photo'] = $_POST['photo'];

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
	
	// function patch for respecting alpha work find on http://php.net/manual/fr/function.imagecopymerge.php
	$cut = imagecreatetruecolor($src_w, $src_h); 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

file_put_contents("prout", $_POST['value']);
file_put_contents("prout2", $_POST['photo']);

list($type, $data) = explode(';', $_POST['photo']);
list(, $data) = explode(',', $data);

$data = str_replace(" ", "+", $data);

$data = base64_decode($data);

if (!file_exists("../img/".$_SESSION['user']))
    	mkdir("../img/".$_SESSION['user']);

$nb = 0;

while (file_exists("../img/".$_SESSION['user']."/img".$nb.".png")) {
	$nb = $nb + 1;
}

file_put_contents("../img/".$_SESSION['user']."/img".$nb.".png", $data);


header ("Content-type: image/png");

// Traitement de l'image source
$source = imagecreatefrompng("./photo_camagram/cadre3.png");
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
imagealphablending($source, true);
imagesavealpha($source, true);
 
// Traitement de l'image destination
$destination = imagecreatefrompng("../img/".$_SESSION['user']."/img".$nb.".png");
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
  
// Calcul des coordonnées pour placer l'image source dans l'image de destination
$destination_x = ($largeur_destination - $largeur_source)/2;
$destination_y =  ($hauteur_destination - $hauteur_source)/2;
  
// On place l'image source dans l'image de destination
//imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);


imagepng($destination, "./creation.png");

$userName = $_SESSION['user'];
$filepath = "../img/".$_SESSION['user']."/img".$nb.".png";

$data = $db->prepare("INSERT INTO image(user,filepath) VALUES(:userName, :filepath)");
$data->execute(Array(
	'userName' => $userName,
	'filepath' => $filepath
));

?>