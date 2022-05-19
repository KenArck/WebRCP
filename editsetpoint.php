<?php
include("global.php");

$id = $_GET['id'] ?? '' ;

//$d=$_POST['d'];
//$sub=$_POST['sub'];
$day = $_POST['day'] ?? '';
$hour = $_POST['hour'] ?? '';
$month = $_POST['month'] ?? '';
$minute = $_POST['minute'] ?? '';
$macro = $_POST['macro'] ?? '';
$comment=$_POST['comment'] ?? '';
$monthname=null;

if(isset($_POST['cancel'])){
	header("Location: setpoints.php\n\n");
	exit();
}
if(isset($_POST['submitted'])){	
	if(strlen($month) == 1){ $month = "0$month"; }
	$d = "$day $month $hour $minute $macro";
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";
	$result=safe_query($query);
	header("Location: setpoints.php\n\n");
	exit();
}

include("header.php");
?>
<SCRIPT LANGUAGE=JavaScript>
<!--
function open_funct() { 
  var nwin = window.open("macrofunctions.php","functpopup","width=270,height=600,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;
}
// -->
</SCRIPT>

<?php
$query="select * from config where id = $id";
$result=safe_query($query);

$row=mysqli_fetch_array($result);

$d =  str_replace(  " ", "", $row['cdata'] );
$l = strlen($d);
$day=substr($d,0,1);
$hour=substr($d,1,2);
$month=substr($d,3,2);
$minute=substr($d,5,2);
$macro=substr($d,7,2);


print "
<P>&nbsp;</P>
<form name=\"spbuild\" action=\"editsetpoint.php?id=$id\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>Edit Set Point</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	print "		
				<TR>
					<td><B>Set Point #:</B></td>
					<td>$row[sub]</td>
				</tr>
				<tr>
					<td><B>Day of Week:</B></td>
					<td>
						<select name=\"day\">";
							$dayquery="select * from DOW order by id";
							$dow=safe_query($dayquery);
							while( $drow = mysqli_fetch_array($dow) ){
								print "<option value=\"$drow[id]\"";
								if($day == $drow['id']){
									print "SELECTED";
								}
								print ">$drow[days]\n";
							}
print"							
						</select>
					</td>
				</tr>
				
				<tr>			
					<td><B>Month:</B></td>
					<td>
						<select name=\"month\">";
						$monthquery="select * from MOY order by id";
							$moy=safe_query($monthquery);
							while($mrow = mysqli_fetch_array($moy)){
								print "<option value=\"$mrow[id]\"";
								if($month == $mrow['id']){print "SELECTED";}
								print ">$mrow[months]\n";
							}
				
print "				
				<tr>
					<td><B>Hour:</B></td>
					<td>
						<select name=\"hour\">
							<option value=\"25\"";
							if($hour == "25"){ 
								print "SELECTED"; 
							}
print"							>DISABLED

							<option value=\"99\"";
							if($hour == "99"){ 
								print "SELECTED"; 
							}
print"							>All Hours";
							
							for( $hr = 0; $hr < 24 ; $hr++){
								if(strlen($hr) == 1){ $hr = "0$hr"; }
								print "<option value=\"$hr\" ";
								if($hour == $hr){
									print "SELECTED";
								}
								print ">$hr\n";
							}
print"							
						</select>
					</td>
				</tr>";			
				
			
				
print"							
						</select>
					</td>
					</td>
				</tr>	
				<tr>			
					<td><B>Minute:</B></td>
					<td>
						<select name=\"minute\">";
							for( $m = 0; $m < 60 ; $m++){
								if(strlen($m) == 1){ $m = "0$m"; }
								print "<option value=\"$m\" ";
								if($minute == $m){
									print "SELECTED";
								}
								print ">$m\n";
							}
print"							
						</select>
					</td>
					</td>
				</tr>
				<tr>
					<td><B>Macro:</B></td>
					<td>";
						$macroquery = "select * from config where type = 'macro' order by sub";
						$macroresult = safe_query($macroquery);
print "					<select name=\"macro\">";

/*							for( $m = 1; $m < 81 ; $m++){
								if(strlen($m) == 1){ $m = "0$m"; }
								print "<option value=\"$m\" ";
								if($macro == $m){
									print "SELECTED";
								}
								print ">$m\n";
							}
*/
							while( $macrorow = mysqli_fetch_array($macroresult) ){
								print "<option value=\"$macrorow[sub]\"";
								if($macro == $macrorow['sub']) print "SELECTED";						
print"								>$macrorow[sub] $macrorow[comment]\n";
								

							}

print"							
						</select>
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

