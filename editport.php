<?php
include("global.php");

$port = $_GET['port'];
$id = $_GET['id'];
$tab = $_GET['tab'];

$comment = $_POST['comment'];
$data = $_POST['data'];
$translate = $_POST['translate'];
$row = $_POST['row'];
$d = $_POST['d'];

if(isset($_POST['cancel'])){
	header("Location: ports.php?port=$port&tab=$tab\n\n");
	exit();
}


if(isset($_POST['submitted']) && $_POST['submitted'] !="Refresh"){
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";
	$result=safe_query($query);
	header("Location: ports.php?port=$port&tab=$tab\n\n");
	exit();
}

include("header.php");
?>
<SCRIPT LANGUAGE=JavaScript>

function open_funct() { 
  var nwin = window.open("cwcodes.php","functpopup","width=120,height=600,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;
	}
function open_funct2() { 
  var nwin = window.open("vocabcodes.php","functpopup","width=150,height=600,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;
}

</SCRIPT>

<?php

$query="select * from config where id = $id";

$result=safe_query($query);
$row=mysqli_fetch_array($result);
$data = $row['cdata'];

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
	

				if ( $row['command'] != "*8007") {
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
						if( substr($row['description'],0,7) == "CW ID #") {
						print "
						<SCRIPT LANGUAGE=JavaScript>
						<!--
						 document.write(\"<input type=button value=\\\"Lookup\\\" onclick='javascript:open_funct();'>\");            
						// -->
						</SCRIPT>
						";
						}
						
						if($row['command'] == '*8004' || $row['command'] == '*8005' || $row['command'] == '*8006' || $row['command']=="*2103"){
						print "
						<SCRIPT LANGUAGE=JavaScript>
						<!--
						 document.write(\"<input type=button value=\\\"Lookup\\\" onclick='javascript:open_funct2();'>\");            
						// -->
						</SCRIPT>
						";
						}
					print "</td>";
				} else { //if *8007 (ID Extra)
					print "
					<td><B>ID Extra:</B></td>					
					<td><select name=\"d\">";
						
						$query = "select * from IDextras order by id";
						
						$extra=safe_query($query);
						while( $r=mysqli_fetch_array($extra)) {
							
			
						print "<option value=\"$r[id]\"";
							if( $r[id] == $data) {
								print "SELECTED";
							}
							print" >$r[id] - $r[comment]";
						}
						print "</select></td>";
				}


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
					if(isset($_GET['vocab'])){
						print "<input type=\"submit\" value=\"Refresh\" name=\"refresh\" >";
					}


	print"					<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >";

	print 				"<input type=\"hidden\" value=\"$id\" name=\"id\">
					</TD>
				</TR>	
	
				
				</TR>
				<tr><td colspan=2><B>$row[help]</b></td></tr>
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
				$lookup=mysqli_fetch_array($lu);
				print $funct . " - " . $lookup[word] . " ";
				$dvrquery="select * from DVRtracks where vocabnum = $funct";
				$dvrresult=safe_query($dvrquery);
				$dvrrow=mysqli_fetch_array($dvrresult);
				if($dvrrow['contents'] != ""){
					print "($dvrrow[contents]) ";
				}
				print "<BR>";					
			}
			print "</B>";
		
		print "</td></tr>";
}	



if(  $row['command'] == "*8002" || $row['command'] == "*8003" ) {
			$d =  str_replace(  " ", "", $row[cdata] );
			$l = strlen($d);						
			print "<tr><td colspan=\"2\"><HR>";
			print "<B>";
			for ($p = 0; $p < $l ; $p+=2){
				$funct = substr($d,$p,2);			
				$lookupquery = "select * from cw where code = $funct";
				$lu = safe_query($lookupquery);
				$lookup=mysqli_fetch_array($lu);
				print $funct . " - " . $lookup[letter] . " ";		
				print "<BR>";
			}
			print "</B>";	

		print "</td></tr>";	
}	
				
				
Print "		</table>
		</td>
	</tr>
</table>
</form>";




include("footer.php");
?>

