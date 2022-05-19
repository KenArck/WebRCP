<?php
include("global.php");

$comment = $_POST['comment'];
$id = $_POST['id'];
$tab = $_POST['tab'];


if(isset($_POST['cancel'])){
	header("Location: codes.php\n\n");
	exit();
}

if(isset($_POST['submitted'])){
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";
	$result=safe_query($query);
	header("Location: codes.php?tab=$tab\n\n");
	exit();
}

include("header.php");

$query="select * from config where id = $id";
$result=safe_query($query);
$row=mysql_fetch_array($result);

print "
<P>&nbsp;</P>
<form name=\"editcode\" action=\"editcode.php?id=$id&tab=$tab\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>";
	if( $row[port] != 0){
		print "PORT $row[port] - ";
	}	
	print "$row[description] code</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	print "		
				<TR>
					<td><B>Code:</B></td>
					<td><input type=\"text\" name=\"d\" value=\"$row[cdata]\" size=\"50\" >";
	print "			
					</td>
				</tr><TR>
					<td>
						<B>Comment:</B>
					</td>
					<td>
						<input type=\"text\" name=\"comment\" value=\"$row[comment]\" size=\"50\">
					</td>
				</tr><tr>
					<TD colspan=2>
						<input type=\"submit\" value=\"Save\" name=\"submitted\">
						<input type=\"submit\" value=\"Cancel\" name=\"cancel\">
					</TD>
				</TR>	";

Print "		</table>
		</td>
	</tr>
</table>
</form>";




include("footer.php");
?>

