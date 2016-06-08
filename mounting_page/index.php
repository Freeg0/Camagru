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
	<title>Camagru - Mounting page</title>
</head>
<body>

	<p style="text-align:center;"><img align="middle" src="http://img.linuxfr.org/img/68747470733a2f2f75706c6f61642e77696b696d656469612e6f72672f77696b6970656469612f636f6d6d6f6e732f352f35362f416e737765725f746f5f4c6966652e706e67/Answer_to_Life.png" title="42"/></p>
	<p style="text-align: center; font-size: 30px; font-weight: bold; color: #3B0B17;">- Camagram -</p>
<Div id="Topbar">
	<Div class="topbar"></Div>
</Div>

<video id="video"></video>
<button id="startbutton">- Snap Photo -</button>
<canvas id="canvas"></canvas>

<script type="text/javascript">(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 500,
      height = 500;

  navigator.getMedia = ( navigator.getUserMedia || 
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    { 
      video: true, 
      audio: false 
    },
    function(stream) {
      if (navigator.mozGetUserMedia) { 
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    // photo.setAttribute('src', data);
    var canvass = document.getElementById("canvas");
    var canvasData = canvass.toDataURL("image/png");
    var radios = document.getElementsByName('choix');
    var choix;

    for (var i = 0, length = radios.length; i < length; i++) {
      if (radios[i].checked) {
        choix = radios[i].value;
        break;
      }
    }
    var ajax = new XMLHttpRequest();
    ajax.open("POST",'upload_canvas.php',false);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send("photo=" + canvasData + "&value=" + choix);
    // var ajax2 = new XMLHttpRequest();
    // ajax2.open("POST",'upload_canvas.php',false);
    // ajax2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // ajax.send("value=" + choix);
    // console.log(canvasData);
    // redirect();
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
  }, false);

})();</script>

<Div id="photomontage">
  <img style="height: 200px; width: 200px;" src="photo_camagram/cadre1.png" />
  <INPUT type="radio" name="choix" value="1"/>
  <img style="margin-left: 25px; height: 200px; width: 200px;" src="photo_camagram/cadre2.png" />
  <INPUT type="radio" name="choix" value="2"/>
  <img style="margin-left: 25px; height: 200px; width: 200px;" src="photo_camagram/cadre3.png" />
  <INPUT type="radio" name="choix" value="3"/>
</Div>

<Div id="galerie">
<?php
  include '../config/setup.php';

  $sth = $db->prepare("SELECT filepath FROM image");
  $sth->execute();

  $result = $sth->fetchall();

  foreach ($result as $results) {
echo <<<EOT
  <img style="margin: 1%; height: 200px; width: 213px;" src="$results[0]" />
EOT;
}

?>
</Div>

<Div id="Footer">
	<Div class="footer"></Div>
</Div>

</body>
</html>