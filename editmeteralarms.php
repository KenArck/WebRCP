<?php
include("global.php");

$port = $_GET['port'] ;
$id = $_GET['id'] ;
$tab = $_GET['tab'];

$comment = $_POST['comment'] ?? '';
$alarmhilow = $_POST['alarmhilow'] ?? '';
$alarmmeter = $_POST['alarmmeter'] ?? '';
$alarmtrip = $_POST['alarmtrip'] ?? '';
$alarmmacro = $_POST['alarmmacro'] ?? '';

$alarmnum=array("","1","2","3","4","5","6","7","8");
$alarmtypes=array("Alarm OFF","Low","High");
$alarmmacronum =array("","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59", "60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88","89","90");


if(isset($_POST['cancel'])){
	header("Location: ports.php?port=$port&tab=$tab\n\n");
	exit();
}

if(isset($_POST['submitted'])){ 	
if(strlen($alarmmacro) < 2){$alarmmacro = "0" . $alarmmacro;}
	$d = $alarmmeter . " " . $alarmhilow . " " . $alarmtrip . " " . $alarmmacro;
//	print "$alarmmeter";
//    print "$d";
//  print "$id";
	
//	if( $alarmhilow == '0'){ $d ="NOT SET";}	//if no meter alarm programmed, force "not set" in display upon load
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



$alarmparam  = explode(" ", $row['cdata'] );


for($i=0 ; $i < 4 ; $i++){	
	$alarmparam[$i] = $alarmparam[$i] ;
	If($alarmparam[2] == ""){$alarmparam[2] = "0";}
}

print "
<P>&nbsp;</P>
<form name=\"editmeteralarms\" action=\"editmeteralarms.php?port=$port&id=$id&tab=$tab\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"500\">
	<tr><TD class=\"titlebar\"><B>";
	print "$row[description]</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";				
				print "
				<td><B>Meter To Use</B></td>
				<td>
				<select name=\"alarmmeter\">";
				for($i=0; $i<8; $i++){				
					if($i == $alarmparam[0]){$selected="SELECTED"; } else {$selected=""; }
						print "<option value=\"$i\" $selected>$alarmnum[$i]\n";
					}								

print "					</select>
					</td>
				</tr>
				<tr><td><B>Alarm Type</B></td><td>
				<select name=\"alarmhilow\">";
				for($i=0; $i<3; $i++){
					if($i == $alarmparam[1]){$selected="SELECTED"; } else {$selected=""; }
					print "<option value=\"$i\" $selected>$alarmtypes[$i]\n";
				}
		
		print"		</tr>
				<tr>
				<td><B>Trip Point (real value x 100)</B></td>
				<td><input type=\"text\" name=\"alarmtrip\" value=\"$alarmparam[2]\"></td>
				</tr>				
				<tr>
				
				<td><B>Macro To Call</B></td><td>
				<select name=\"alarmmacro\">";
					for($i=0; $i< 91; $i++){
						if($i == $alarmparam[3]){ $selected="SELECTED"; } else {$selected=""; }
						print "<option value=\"$i\" $selected>$alarmmacronum[$i]\n";
					}
				
	print "	</tr>		
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

