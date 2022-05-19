<?php
include("header.php");
include("global.php");

print "<table align=\"center\" cellspacing=0 cellpadding=25><TR><td valign=\"top\">";

$query="select * from vocab where id >= 0 and id < 51 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td>$row[word]</td>
		</TR>";
}
Print "	</table>";

print "</td><td valign=\"top\">";

$query="select * from vocab where id > 50 and id < 102 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td>$row[word]</td>
		</TR>";
}
Print "	</table>";

print "</td><td valign=\"top\">";

$query="select * from vocab where id > 101 and id < 153 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td>$row[word]</td>
		</TR>";
}
Print "	</table>";



print "</td><td valign=\"top\">";

$query="select * from vocab where id > 152 and id < 204 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td>$row[word]</td>
		</TR>";
}
Print "	</table>";

print "</td><td valign=\"top\">";

$query="select * from vocab where id > 204 order by id";
$result=safe_query($query);
	
print" <table align=\"center\" border=0 cellspacing=0 cellpadding=2>";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td><b>$row[id]</td></b>
		<td>$row[word]</td>
		</TR>";
}
Print "	</table>";




print "</td></TR></table>";


include("footer.php");
?>

