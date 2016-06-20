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
  	<li><a href="./index.php" onclick="">Gallery</a></li>
    <li><a href="../mounting_page" onclick="">Mouting page</a></li>
    <li><a href="../" onclick="">logout</a></li>
    <li><a href="#" onclick="">Hi <?php echo $_SESSION['user']; ?> !</a></li>
  </ul>
</Div>

<Div>
<?php $_SESSION['src'] = $_POST['src']; ?>
<?php

include '../config/setup.php';

if (file_exists("tmp1")) {
	$myfile = fopen("tmp1", "r") or die("Unable to open file!");
	$f = fread($myfile,filesize("tmp1"));
	fclose($myfile);
}
else {
	$myfile = fopen("tmp2", "r") or die("Unable to open file!");
	$f = fread($myfile,filesize("tmp2"));
	fclose($myfile);
}

$_SESSION['path'] = $f;

echo <<<EOT
  <p style="text-align:center;"><img style="margin: 1%; height: 400px; width: 400px;" src="$f" /></p>
EOT;

if (file_exists("tmp1")) {
	copy("tmp1", "tmp2");
	unlink("tmp1");
}

$data = $db->prepare("SELECT id FROM `like` WHERE filepathimage = :f");
$data->execute(Array(
		'f' => $f
	));

$nb_like = $data->rowCount();

echo <<<EOT
	<p style="text-align:center; margin: 0 auto; "><img align="middle" src="coeur.png" title="42"/></p>
	<form method="post" action="like.php">
		<p style="text-align:center; margin: 0 auto; ">$nb_like<input type="submit" name="submit" value="Like" id="likeit"/></p>
	</form>
EOT;

?>
</Div>

<Div id="commentdiv">
<?php

$user1 = $_SESSION['user'];
$file = $_SESSION['path'];

$sth = $db->prepare("SELECT comment FROM comments WHERE filepathimage = :file");
$sth->execute(Array(
		'file' => $file
	));


$result = $sth->fetchall();

foreach ($result as $results) {
echo <<<EOT
		<b style="color: black;">$user1 : $results[0]</b></br>
EOT;
}
?>

	<form method="post" action="comment.php">
		<input type="text" name="commentaire" value=""/>
		<input type="submit" name="submit" value="comment"/>
	</form>
</Div>

<Div id="Footer">
	<Div class="footer"></Div>
</Div>

</body>
</html>