<?php
include("header.php");
?>
<HEAD>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
</HEAD>

<script  src="jquery.js"></script>
<script>
function myFunction() {	  	
	$.get("rundownload.php", function(data, status){	
	//alert("Contents Successfully Downloaded");
	alert(data, status);
	window.close();	
	window.location="ports.php?port=1&tab=1";
	});	
}
</script>

<body style="text-align:center" onload="myFunction()">
</body>
<?php
print"
<br></br><br></br>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Downloading....</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>					
			<H3><CENTER>Download started. This may take a minute or two to complete. Please standby and do not navigate away from this page until it finishes. The downloaded data will be loaded upon completion</H3></CENTER>
			<CENTER><img src = \"images/ajax-loader.gif\"></CENTER>				
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
";
include("footer.php");
?>





