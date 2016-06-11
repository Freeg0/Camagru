<?php
	session_start();

	if ($_SESSION['src'])
		file_put_contents("tmp1", $_SESSION['src'], FILE_APPEND);
	if (!$_SESSION['loginOK']) {
		header('Location: ../'); 
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="index.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8"/>
	<title>Camagru - Gallery</title>
</head>
<body>
	<p style="text-align:center;"><img align="middle" src="http://img.linuxfr.org/img/68747470733a2f2f75706c6f61642e77696b696d656469612e6f72672f77696b6970656469612f636f6d6d6f6e732f352f35362f416e737765725f746f5f4c6966652e706e67/Answer_to_Life.png" title="42"/></p>
	<p style="text-align: center; font-size: 30px; font-weight: bold; color: #3B0B17;">- Camagram -</p>
<Div id="Topbar">
	<Div class="topbar"></Div>
  <ul>
  	<li><a href="./index.php" onClick="">Gallery</a></li>
    <li><a href="../mounting_page" onClick="">Mouting page</a></li>
    <li><a href="../" onClick="">logout</a></li>
    <li><a href="#" onClick="">Hi <?php echo $_SESSION['user']; ?> !</a></li>
  </ul>
</Div>

<Div>
<?php $_SESSION['src'] = $_POST['src']; ?>
<?php
if (file_exists("tmp1")) {
	$myfile = fopen("tmp1", "r") or die("Unable to open file!");
	$lol = fread($myfile,filesize("tmp1"));
	fclose($myfile);
}
else {
	$myfile = fopen("tmp2", "r") or die("Unable to open file!");
	$lol = fread($myfile,filesize("tmp2"));
	fclose($myfile);
}

echo <<<EOT
  <p style="text-align:center;"><img style="margin: 1%; height: 400px; width: 400px;" src="$lol" /></p>
EOT;

if (file_exists("tmp1")) {
	copy("tmp1", "tmp2");
	unlink("tmp1");
}

?>
</Div>

<Div id="Footer">
	<Div class="footer"></Div>
</Div>

</body>
</html>