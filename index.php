<?php
session_start();

$_SESSION['loginOK'] = False;

?>

<!DOCTYPE html>
<html>
<head>
	<link href="index.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8"/>
	<title>Camagru - Montage photo</title>
</head>
<body>
	<p style="text-align:center;"><img align="middle" src="http://img.linuxfr.org/img/68747470733a2f2f75706c6f61642e77696b696d656469612e6f72672f77696b6970656469612f636f6d6d6f6e732f352f35362f416e737765725f746f5f4c6966652e706e67/Answer_to_Life.png" title="42"/></p>
	<p style="text-align: center; font-size: 30px; font-weight: bold; color: #3B0B17;">- Camagram -</p>
<Div id="Topbar">
	<Div class="topbar"></Div>
</Div>

<Div id="choice">
	<Div id="signin">
		<h3>Sign-In</h3>
		<form method="post" action="signin.php">
			<a>Username :<input type="text" name="login" value="" /></a>
			</br>
			<a>Password :<input type="password" name="password" value="" /></a>
			</br>
			<a href="mounting_page/"><input type="submit" name="submit" value="Sign-In" /></a>
		</form>
	</Div>

	<hr width="1" size="200" style="background-color: black; -webkit-margin-start: 7%; -webkit-margin-end: 0; display: inline-block;">

	<Div id="signup">
		<h3>Sign-Up</h3>
		<form method="post" action="signup.php">
			<a>Email adress :<input type="text" name="email" value="" /></a>
			</br>
			<a>Username :<input type="text" name="login" value="" /></a>
			</br>
			<a>Password :<input type="password" name="password" value="" /></a>
			</br>
			<a>Confirm Password :<input type="password" name="cpassword" value="" /></a>
			</br>
			<input type="submit" name="submit" value="Sign-Up" />
		</form>
		<input type="submit" name="submit" value="Password Forget it?" />
	</Div>
</Div>

<Div id="Footer">
	<Div class="footer"></Div>
</Div>

</body>
</html>