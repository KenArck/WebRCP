<?php
include("global.php");

$port = $_GET['port'] ;
$id = $_GET['id'] ;
$tab = $_GET['tab'];

$comment = $_POST['comment'] ?? '';
$face = $_POST['face'] ?? '';
$X1 = $_POST['X1'] ?? '';
$X2 = $_POST['X2'] ?? '';
$Y1 = $_POST['Y1'] ?? '';
$Y2 = $_POST['Y2'] ?? '';

$facetypes=array("Meter OFF","Volts","Amps","Watts","Degrees","MPH","Percent");

if(isset($_POST['cancel'])){
	header("Location: ports.php?port=$port&tab=$tab\n\n");
	exit();
}

if(isset($_POST['submitted'])){ 
	$d = $face . " " . $X1 . " " . $Y1 . " " . $X2 . " " . $Y2;
// print "<BR><BR>$d";
 // print "face " . "$face";
	
//	if( $face == '0'){ $d ="Disabled";}	//if no meter face programmed, force "not set" in display upon load
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";			
	$result=safe_query($query);
	header("Location: ports.php?port=$port&tab=$tab\n\n");
    exit();
}

include("header.php");

$query="select * from config where id = $id";

$result=safe_query($query);
$row=mysqli_fetch_array($result);
$mface  = explode(" ", $row['cdata'] );
//print "<BR><BR>";
//Print "mface[0] " . "$mface[0]<BR>";
//Print "mface[1] " ."$mface[1]<BR>";
//Print "mface[2] " ."$mface[2]<BR>";
//Print "mface[3] " ."$mface[3]<BR>";
//Print "mface[4] " ."$mface[4]<BR>";





//for($i=2 ; $i < 3 ; $i++){
//	$mface[$i] = $mface[$i] ;
//}

print "
<P>&nbsp;</P>
<form name=\"editmeter\" action=\"editmeter.php?port=$port&id=$id&tab=$tab\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"500\">
	<tr><TD class=\"titlebar\"><B>";
	print "$row[description]</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
//	print "		
//				<TR>";
				
					print "
					<td><B>Meter Type</B></td>
					<td>
						<select name=\"face\">";
						for($i=0 ; $i<7 ; $i++){
							If($i==$mface[0]){ $selected="SELECTED"; } else { $selected=""; }
							print "<option value=\"$i\" $selected>$facetypes[$i]\n";
						}
						
print "					</select>
					</td>
				</tr>
				<tr>
					<td><B>Actual Low Value (x100)</B></td>
					<td><input type=\"text\" name=\"X1\" value=\"$mface[1]\"></td>
				</tr>
				<tr>
					<td><B>Meter Low Value (x100)</B></td>
					<td><input type=\"text\" name=\"Y1\" value=\"$mface[2]\"></td>
				</tr>
				<tr>
					<td><B>Actual High Value (x100)</B></td>
					<td><input type=\"text\" name=\"X2\" value=\"$mface[3]\"></td>
				</tr>
				<tr>
					<td nowrap><B>Meter High Value (x100)</B></td>
					<td><input type=\"text\" name=\"Y2\" value=\"$mface[4]\"></td>
				</tr>	
				";

	print "			
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
						<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >";

Print "		</table>
		</td>
	</tr>
</table>
</form>";

include("footer.php");
?>

