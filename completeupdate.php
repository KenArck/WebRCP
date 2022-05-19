<HTML>
<title>Send Complete Config</title>
<HEAD>
	<link rel="Stylesheet" rev="Stylesheet" href="stylesheet.css" type="text/css" media="Screen">
</HEAD>

<CENTER><H4>Please wait while the load is done</H4></CENTER>

<center><img src="ajax-loader.gif" alt="Loader" style="width:30px;height:30px;"></center>

<?php

include("global.php");

sleep(0.5);
exec('wget http://localhost/controlserial.php');

//echo "<script type='text/javascript'>\n";
//echo "document.body.innerHTML = ''";
//echo "</script>";
			
?>

<CENTER><H3>UPLOAD COMPLETE. YOU MAY CLOSE THIS WINDOW<H3></CENTER>

