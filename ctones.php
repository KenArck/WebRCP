<?php
include("header.php");
include("global.php");

$port = $_GET['port'] ;
$tab = $_GET['tab'] ;

$query="select * from config where type like 'prog' and command like '*3%' and port = $port order by description";

$result=safe_query($query);

$c1 = "lightrow";
$c2 = "darkrow";
$cc = $c1;
$linecounter = 0;
// B4A67A 

// The Tabs
	switch ($tab ) {
		case "port1":
			$tabactive=0;
			break;		
		case "port2":
			$tabactive=1;	
		case "port3":
			$tabactive=2;
			break;	
		case "ct":
			$tabactive=3;
			break;
		case "global":
			$tabactive=4;
			break;
		case "phrase":
			$tabactive=5;
			break;
		case "dtmfstring":
			$tabactive=6;
			break;
		case "meters":
			$tabactive=7;
			break;
	}

	$tabtitles=array("Port 1 Settings", "Port 2 Settings", "Port 3 Settings","Courtesy Tones", "Global","Message Macros","DTMF Memories", "Meters");
	$taburl=array("ports.php?tab=port1&port=1", "ports.php?tab=port2&port=2","ports.php?tab=port3&port=3", "ctones.php?tab=ct&port=0","ports.php?tab=global&port=0","ports.php?tab=phrase&port=0","ports.php?tab=dtmfstring&port=0","ports.php?tab=meters&port=0");
//	$tabtitles=array("Port 1 Settings", "Port 1 Courtesy Tones", "Port 2 Settings", "Port 2 Courtesy Tones", "Port 3 Settings","Port 3 Courtesy Tones","Global");
//	$taburl=array("ports.php?tab=port1&port=1","ctones.php?tab=port1ct&port=1","ports.php?tab=port2&port=2","ctones.php?tab=port2ct&port=2","ports.php?tab=port3&port=3","ctones.php?tab=port3ct&port=3","ports.php?tab=global&port=0");
	$tabalign="LEFT";
	$tabwidth="400";
	print "<BR>";


print "
<P>&nbsp;</P>
<table align=\"center\" border=0 cellspacing=0 cellpadding=0>
<!--
	<tr>
		<TD valign=\"bottom\">
		<a href=\"ctclone.php\">Clone Courtesy Tones</a>
		<BR>&nbsp;
		</TD>
	</tr>
	-->

	<tr>
		<TD valign=\"bottom\">";
		include("tabs.php");
		print "</TD>
	</tr>
	<tr>
		<td class=\"darkrow\">


			<table align=\"center\" border=0 cellspacing=0 cellpadding=4 width=\"100%\"> ";

while( $row=mysqli_fetch_array($result) ){
	$linecounter++;
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}
				

print"				<TR class=$cc>
					<td>";						
						
					print"<a href=\"editct.php?id=$row[id]&port=$port&tab=$tab\">";	
					if($row['changed']) print'<B><div class="red">';
					print "$row[command]";							
					if($row['changed']) print '</B>';

print"				</div>
					</a>
					</td>
					";					
					
					
				if($row['changed']){				
				print"<td><B><RED>$row[description]</td>";
			}else{
				print"<td>$row[description]</td>";
			}
					
					
		//	print"		<td>";					
					
			if($row['changed']){				
				print"<td><B><RED>$row[cdata]</td>";
			}else{
				print"<td>$row[cdata]</td>";
			}

	if($row['comment'] != ""){
		print "			<BR>$row[comment]";
	}


print"  			</td>
			</tr>";
	if($linecounter == 4){
		$linecounter = 0;
		print"
		<tr>
			<td colspan=3  height=\"3\"></td>
		</tr>
		";
	}

}
Print "
			</table>
		</td>
	</tr>
</table>";



include("footer.php");

?>

