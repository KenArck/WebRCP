<?php
include("header.php");
include("global.php");

$tab = $_GET['tab'];
$cmd=$_POST['cmd'];
$port=null;


//determine RTC status

$query="select * from vars";
$result=safe_query($query);
while( $vars = mysqli_fetch_array($result) ){	
	if( $vars['name'] == "RTCinfo"){
		$rtc = $vars['value'];	
	}	
}

if(!isset($tab)){
	$tab = "Port1";
}

if($tab == "misc"){
	$wh = "tab is null";
} else {
	$wh = "tab like '%$tab%'";
}

$query="select * from config where type like 'code' and $wh order by command, port";

$result=safe_query($query);

$c1 = "lightrow";
$c2 = "darkrow";
$cc = $c1;

/* B4A67A */

/* The Tabs */
	switch ($tab ) {
		case "Port1":		
			$tabactive=0;
			break;
		case "Port2":
			$tabactive=1;
			break;
		case "Port3":
			$tabactive=2;
			break;
		case "alarms":
			$tabactive=3;
			break;
		case "misc":
			$tabactive=4;
			break;
	}


	$tabtitles=array("Port 1","Port 2","Port 3", "Alarms", "Misc");	
	$taburl=array("codes.php?tab=Port1","codes.php?tab=Port2","codes.php?tab=Port3","codes.php?tab=alarms","codes.php?tab=misc");
	$tabalign="LEFT";
	$tabwidth="400";
		
	print "<BR>";

print "


<H2 align=\"center\" class=\"primarycolor\">Supervisory Commands</H2>
	<P align=\"center\">Click the command on the right to edit.</P> 
	<table align=\"center\" border=0 cellspacing=0 cellpadding=0 width=\"600\">

	<tr >
		<td colspan=4 height=\"50\" valign=\"bottom\">";	
		include("tabs.php");
		print "
		</td>
	</tr>";
//	$query = "select command from config where command = '*2104'";
//	$result = safe_query($query);
//	$row=mysqli_fetch_array($result);	
//	$prefix = $row[command];	
	
	$extra = "";	
	if($tab == "Port1"){
		$query="select * from commands where port = 1 order by code";
		$extra = "Port 1";
	} elseif ($tab == "Port2") {
		$query="select * from commands where port = 2 order by code";
		$extra = "Port 2";
	} elseif ($tab == "Port3") {
		$query="select * from commands where port = 3 order by code";
		$extra = "Port 3";
	} elseif ($tab == "alarms") {
		$query="select * from commands where description like '%alarm%' order by code";
		$extra = "
		";				
	} elseif ($tab == "misc") {
		$query="select * from commands where port <> 1 AND port <> 2 AND
			port <> 3 AND description not like '%alarm%' order by code";	
	}
	
	$result = safe_query($query);
	
	
	
	print "<tr>
			<td class=\"lightrow\">
			<table align=\"center\" border=0 cellspacing=0 cellpadding=4 width=\"100%\"> ";

				
			while( $row=mysqli_fetch_array($result) ){
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}				
				
			print "	
				<TR class=\"$cc\">";
				
				
				
				print "</td><td>";
		if($row['changed']){print '<B><div class="red">';						
			print"<a href=\"editcommands.php?port=$row[port]&code=$row[code]&tab=$tab\"><span class='red'>$row[code]$row[sub]</a>";				
		}else{
			print"<a href=\"editcommands.php?port=$row[port]&code=$row[code]&tab=$tab\">$row[code]$row[sub]</a>";
		}
		if($row['changed']){print "</B></div>";}
					
					
					if($row['changed']) {						
						print'<td><B><span class="red">' . $row['description'] . " " . $extra;
						print'</span>';
					} else {
						print"<td>$row[description] $extra";
					}


					
			if($row['changed']) print '<B><span class="red">';			
			
			if($row['code']=="111" || $row['code'] == "211" || $row['code']=="311"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Disabled";}
				if($row['sub'] == '1'){print "Enabled";}
				print ")</B>";
			}	

			if($row['code']=="112" || $row['code'] == "212" || $row['code']=="312"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Carrier Only";}
				if($row['sub'] == '1'){print "Carrier & Tone";}
				print ")</B>";
			}	

			if($row['code']=="113" || $row['code'] == "213" || $row['code']=="313"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "OFF";}
				if($row['sub'] == '1'){print "ON";}
				print ")</B>";
			}	

			if($row['code']=="114" || $row['code'] == "214" || $row['code']=="314"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Repeat OFF";}
				if($row['sub'] == '1'){print "Repeat ON";}
				print ")</B>";
			}	

			if($row['code']=="115" || $row['code'] == "215" || $row['code']=="315"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Kerchunk Filtering OFF";}
				if($row['sub'] == '1'){print "Kerchunk Filtering ON";}
				print ")</B>";
			}

			if($row['code']=="116" || $row['code'] == "216" || $row['code']=="316"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "DTMF Disabled";}
				if($row['sub'] == '1'){print "DTMF Enabled";}
				print ")</B>";
			}

			if($row['code']=="117" || $row['code'] == "217" || $row['code']=="317"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "DTMF Not Require CTCSS";}
				if($row['sub'] == '1'){print "DTMF Require CTCSS";}
				print ")</B>";
			}
			
			if($row['code']=="118" || $row['code'] == "218" || $row['code']=="318"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "ID Override OFF";}
				if($row['sub'] == '1'){print "ID Override ON";}
				print ")</B>";
			}			
			
			if($row['code']=="119" || $row['code'] == "219" || $row['code']=="319"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Monitor Mute";}
				if($row['sub'] == '1'){print "Monitor Mix";}
				print ")</B>";
			}		
			
			if($row['code']=="120" || $row['code'] == "220" || $row['code']=="320"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Speech Override OFF";}
				if($row['sub'] == '1'){print "Speech Override ON";}
				print ")</B>";
			}
			
			if($row['code']=="121" || $row['code'] == "221" || $row['code']=="321"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "DTMF Mute OFF";}
				if($row['sub'] == '1'){print "DTMF Mute ON";}
				print ")</B>";
			}
			
			if($row['code']=="122" || $row['code'] == "222" || $row['code']=="322"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Evaluate on COS";}
				if($row['sub'] == '1'){print "Evaluate on CTCSS";}
				print ")</B>";
			}
			
			if($row['code']=="191" || $row['code'] == "291" || $row['code']=="391" || $row['code']=="491" || $row['code']=="591"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Alarm OFF";}
				if($row['sub'] == '1'){print "Alarm ON";}
				print ")</B>";
			}
			
			if($row['code']=="270"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Allow DTMF into phone line";}
				if($row['sub'] == '1'){print "Don't allow DTMF into phone line";}
				print ")</B>";
			}

			if($row['code']=="280"){				
				print "<BR><B>(";
				if($row['sub'] == '0'){print "Macro Subset OFF";}
				if($row['sub'] == '1'){print "Macro Subset ON";}
				print ")</B>";
			}	
			print "</td><td></span>";	
		}
		print "</table></td></tr>";	
		
		
//}
print "</table>";



include("footer.php");
?>

