<?php
include("global.php");


$port = $_GET['port'] ?? '';
$code = $_GET['code'] ?? '' ;
$tab = $_GET['tab'] ?? '';

$comment = $_POST['comment'] ?? '';
$data = $_POST['data'] ?? '';
$translate = $_POST['translate'] ?? '';
$row = $_POST['row'] ?? '';
$d = $_POST['d'] ?? '';

if(isset($_POST['cancel'])){
	header("Location:codes.php?port=$port&tab=$tab\n\n");
	exit();
}


if(isset($_POST['submitted']) && $_POST['submitted'] !="Refresh"){
	$query = "update commands
			set sub = '$d', comment='$comment', changed = 1
			where code= $code";
	$result=safe_query($query);
	header("Location: codes.php?port=$port&tab=$tab\n\n");
	exit();
}

include("header.php");

$query="select * from commands where code = $code";

$result=safe_query($query);
$row=mysqli_fetch_array($result);
$data = $row['sub'];

print "
<P>&nbsp;</P>

<form name=\"editmac\" action=\"$_SERVER[REQUEST_URI]\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"500\">
	<tr><TD class=\"titlebar\"><B>";
	if( $port != 0){
		print "PORT $port - ";
	}	
	print "$row[description]</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	print "		
				<TR>";
	

		
					print "
					<td nowrap><B>\n";
			
				if($row['prompt'] != ""){				
						print "$row[prompt]";
					} else {
						print "Data:";
					}
					print "</B></td>
					<td nowrap>\n"; 

				
					DynamicInput($row['inputspec'],$row['specalt'],'d',$data,50,$row['maxsize']);
						
						
					print "</td>";
			
			


	print "			
				</tr><TR>
					<td>
						<B>Comment:</B>
					</td>
					<td>
						<input type=\"text\" name=\"comment\" value=\"$row[comment]\" size=\"50\">
					</td>
				</tr><tr>
					<TD colspan=2>
						<input type=\"hidden\" name=\"tab\" value=\"$tab\">
						<input type=\"submit\" value=\"Save\" name=\"submitted\">";	

	print"					<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >";

	print 				"<input type=\"hidden\" value=\"$code\" name=\"id\">
					</TD>
				</TR>	
	
				
				</TR>
				<tr><td colspan=2>$row[help]</td></tr>
				";

if(isset($_GET['vocab'])){
		print "<tr><td colspan=\"2\"><HR>";
			$d =  str_replace(  " ", "", $row[cdata] );
			$l = strlen($d);
			print "<B>";
			for ($p = 0; $p < $l ; $p+=3){
				$funct = substr($d,$p,3);
				$lookupquery = "select * from vocab where id = $funct";
				$lu = safe_query($lookupquery);
				$lookup=mysql_fetch_array($lu);
				print $funct . " - " . $lookup[word] . " ";
				$dvrquery="select * from DVRtracks where vocabnum = $funct";
				$dvrresult=safe_query($dvrquery);
				$dvrrow=mysql_fetch_array($dvrresult);
				if($dvrrow[contents] != ""){
					print "($dvrrow[contents]) ";
				}
				print "<BR>";					
			}
			print "</B>";
		
		print "</td></tr>";
}	
				


if(isset($_GET["command"])){

if($row['command'] == "*8002" || $row['command'] == "*8003" ) {
			$d =  str_replace(  " ", "", $row['cdata'] );
			$l = strlen($d);						
			print "<tr><td colspan=\"2\"><HR>";
			print "<B>";
			for ($p = 0; $p < $l ; $p+=2){
				$funct = substr($d,$p,2);			
				$lookupquery = "select * from cw where code = $funct";
				$lu = safe_query($lookupquery);
				$lookup=mysql_fetch_array($lu);
				print $funct . " - " . $lookup[letter] . " ";		
				print "<BR>";
			}
			print "</B>";	

		print "</td></tr>";	
}	
}
				
				
Print "		</table>
		</td>
	</tr>
</table>
</form>";




include("footer.php");
?>

