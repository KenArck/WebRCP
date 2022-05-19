<?php

//system("killall controllinkd");
//passthru("/usr/local/bin/controllinkd beavercreek > /dev/null 2>&1&");

include("header.php");
include("global.php");
?>

<meta http-equiv="refresh" content="0; URL='ports.php?port=1&tab=1'" />

<SCRIPT LANGUAGE=JavaScript>
<!--
function smallpopUp(url) {
myWin=window.open(url,"win",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=1,height=1');
self.name = "mainWin"; }
// -->
</SCRIPT>
<?php



/*

$query = "select * from custom order by description";
$result=safe_query($query);

print "<table align=\"center\" cellpadding=\"3\" cellspacing=\"0\">";
while( $row=mysql_fetch_array($result) ){
	print "<tr>
			<td>
				<a href=\"javascript:smallpopUp('sendcmd.php?cmd=$row[dtmf]')\">$row[description]</a>
			</td>
		</tr>";
}		
print "</table>";

*/

include("footer.php");
?>

