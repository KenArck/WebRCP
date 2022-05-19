<?php

include("global.php");
include("header.php");


print"
<form  action=\"webdownloader.php\" name=\"myform\" method=\"post\" enctype=\"multipart/form-data\">
<br></br><br></br>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Download from RC210</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>
					 <CENTER><input type=\"submit\" value=\"Download\" name=\"submit\"></CENTER>
					 <CENTER><H3>Downloading will cause controller to suspend all other operations. Click the Download button to continue</CENTER></H3>
				
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
";

include("footer.php");




?>