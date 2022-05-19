<?php
include("global.php");

$port = $_GET['port'];
$id = $_GET['id'];


$delay= $_POST['delay'];
$duration=$_POST['duration'];
$tone1=$_POST['tone1'];
$tone2=$_POST['tone2'];
$comment= $_POST['comment'];
$tab = null;


if(isset($_POST['cancel'])){
	header("Location: ctones.php?port=$port\n\n");
	exit();
}

if(isset($_POST['submitted'])){
	$d = $delay . " ".  $duration . " ".  $tone1 . " " . $tone2;
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";
	$result=safe_query($query);
	header("Location: ctones.php?port=$port&tab=$tab\n\n");
	exit();
}

include("header.php");

$query="select * from config where id = $id";

$result=safe_query($query);
$row=mysqli_fetch_array($result);

list($delay,$duration,$tone1,$tone2)= explode (" ", $row['cdata'], 6);
$delay=trim($delay);
$duration=trim($duration);
$tone1=trim($tone1);
$tone2=trim($tone2);

print "
<P>&nbsp;</P>
<form name=\"spbuild\" action=\"editct.php?id=$id&port=$port&tab=$tab\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>Edit $row[description]</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>
				<tr>
					<td><B>Delay:</B></td>
					<td>					
				<input type=\"text\" name=\"delay\" value=\"$delay\" size=\"6\"><B>   milliseconds</B>
				</td>
				</tr>
				<tr>
					<td><B>Duration:</B></td>
					<td>
						<input type=\"text\" name=\"duration\" value=\"$duration\" size=\"6\"><B>   milliseconds</B>
					</td>
				</tr>
				<tr>
					<td><B>Tone 1:</B></td>
					<td>
						<input type=\"text\" name=\"tone1\" value=\"$tone1\" size=\"6\"><B>   Hz</B>
					</td>
				</tr>
				<tr>
					<td><B>Tone 2:</B></td>
					<td>
						<input type=\"text\" name=\"tone2\" value=\"$tone2\" size=\"6\"><B>   Hz</B>
					</td>
				</tr>
				<TR>
					<td>
						<B>Comment:</B>
					</td>
					<td>
						<input type=\"text\" name=\"comment\" value=\"$row[comment]\" size=\"50\">
					</td>
				</tr><tr>
					<TD colspan=2>
						<input type=\"submit\" value=\"Save\" name=\"submitted\">
						<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >
					</TD>
				</TR>	";

Print "		</table>
		</td>
	</tr>
</table>
</form>";




include("footer.php");

?>

