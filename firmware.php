
<?php
include("global.php");
include("header.php");



print"
<form  action=\"preupload.php\" name=\"myform\" method=\"post\" enctype=\"multipart/form-data\">
<br></br><br></br>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Upload Firmware</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>			
				<tr>
					<td colspan=2>
					 <input type=\"file\" name=\"fileToUpload\">					
				     <input type=\"submit\" value=\"Upload to server\" name=\"submit\">
					 <CENTER><H3>Use the Browse button to select the firmware file you want to upload</CENTER></H3>
					</td>
				</tr>				
				<tr>
					
					<td colspan=2>
						<ul>
						</ul
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
";

include("footer.php");

?>