<?php
include("header.php");
include("global.php");

print "<table align=\"center\" cellspacing=0 cellpadding=10><TR><p><td valign=\"top\">";

$query="select * from mfunctions where id > 0 and id < 263 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td nowrap>$row[description]</td>
		</TR>";
}
Print "	</table>";

print "</td><td valign=\"top\">";

$query="select * from mfunctions where id > 262 and id < 524 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td nowrap >$row[description]</td>
		</TR>";
}
Print "	</table>";

print "</td><td  valign=\"top\">";

$query="select * from mfunctions where id > 523 and id < 890 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td nowrap>$row[description]</td>
		</TR>";
}
Print "	</table>";

print "</td><td  valign=\"top\">";

$query="select * from mfunctions where id > 900 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td nowrap>$row[description]</td>
		</TR>";
}
Print "	</table>";


print "</td></TR></table>";


include("footer.php");
?>

