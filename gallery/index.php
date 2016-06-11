<?php
  session_start();
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
    <li><a href="../mounting_page">Mouting page</a></li>
    <li><a href="../">logout</a></li>
    <li><a href="#">Hi <?php echo $_SESSION['user']; ?> !</a></li>
  </ul>
</Div>

<script type="text/javascript">

function recover_src(id){
  var src;
  src = document.getElementById(id).src;
  console.log(src);
  var ajax = new XMLHttpRequest();
  ajax.open("POST",'picture_page.php',false);
  ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  ajax.send("src=" + src);
}

</script>

<Div id="galerie">
<?php
  include '../config/setup.php';

  $nb = 0;
  
  $sth = $db->prepare("SELECT filepath FROM image");
  $sth->execute();

  $result = $sth->fetchall();

  foreach ($result as $results) {
echo <<<EOT
  <a href="./picture_page.php" onclick="recover_src('$nb')"><img style="margin: 1%; height: 200px; width: 213px;" id="$nb" src="$results[0]" /></a>
EOT;
    $nb = $nb + 1;
}

?>
</Div>


<Div id="Footer">
	<Div class="footer"></Div>
</Div>

</body>
</html>