<?php
include("header.php");
include("global.php");


$query="select * from vocab order by id";

$result=safe_query($query);

print "
	<table align=\"center\" border=1 cellspacing=0 cellpadding=2>
		<tr><TD><B>Num</B></TD><TD><B>Word</B></TD></tr>
	 ";
while( $row=mysql_fetch_array($result) ){
	print "<TR>
		<td>$row[id]</td>
		<td>$row[word]</td>
		</TR>";

}
Print "	</table>";

include("footer.php");
?>

