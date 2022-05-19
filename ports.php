<?php
include("header.php");
include("global.php");

$port = $_GET['port'] ;
//$id = $_GET['id'] ;
$tab = $_GET['tab'];
//$command = $_GET['command'];
$query = null;
$vars = null;
$rtc = null;
$eeprom = null;
$row=null;


//determine RTC status
$query="select * from vars";

$result=safe_query($query);

while( $vars = mysqli_fetch_array($result) ){	
	if( $vars['name'] == "RTCinfo"){
		$rtc = $vars['value'];	
	}
	if( $vars['name'] == "EEPROMinfo"){
		$eeprom = $vars['value'];	
	}
}

if( $port != 0 ) {
	$query="select * from config 
			where type like 'prog' and 
			port = $port and 
			command not like '*3%'
			order by command, sub";
} else {
	$query="select * from config 
			where type like 'prog' and 
			tab = '$tab' and 
			command not like '*3%'
			order by command, sub";
		

}

$result=safe_query($query);

$c1 = "darkrow";
$c2 = "lightrow";
$cc = $c1;

/* The Tabs */
	switch ($tab ) {
		case "port1":
			$tabactive=0;
			break;		
		case "port2":
			$tabactive=1;
			break;
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

	$tabtitles=array("Port 1 Settings", "Port 2 Settings", "Port 3 Settings", "Courtesy Tones", "Global","Message Macros","DTMF Memories", "Meters");
	$taburl=array("ports.php?tab=port1&port=1","ports.php?tab=port2&port=2","ports.php?tab=port3&port=3", "ctones.php?tab=ct&port=0","ports.php?tab=global&port=0","ports.php?tab=phrase&port=0","ports.php?tab=dtmfstring&port=0","ports.php?tab=meters&port=0");
	$tabalign="LEFT";
	$tabwidth="400";
	print "<BR>";

print "
<p>&nbsp;</p>

<H2 align=\"center\" class=\"primarycolor\">Port and Global Programming</H2>
	<P align=\"center\">Click the command on the left to edit.</P> 
	<table align=\"center\" border=0 cellspacing=0 cellpadding=0 width=\"600\">


<table align=\"center\" border=0 cellspacing=0 cellpadding=0>
	<tr >
		<TD valign=\"bottom\">";
			include("tabs.php");
Print "	</TD>
	</tr>
	<tr>
		<td>
			<table align=\"center\" width=\"100%\" border=0 cellspacing=0 cellpadding=4> ";
			
$counter = 0;
				
while($row=mysqli_fetch_array($result) ){
	$counter = $counter + 1;
	if($cc == $c1){
		$cc = $c2;
	} else {
		$cc = $c1;
	}
	print "<TR class=\"$cc\"><td>";
					
	if($row['command'] == '*2064'){
		print "<a href=\"editmeter.php?port=$port&id=$row[id]&tab=$tab\">";
	}elseif($row['command'] == '*2066') {
		print "<a href=\"editmeteralarms.php?port=$port&id=$row[id]&tab=$tab\">";	
	
	
	} elseif($row['command'] == '*2103') {
		print "<a href=\"editport.php?port=$port&id=$row[id]&tab=$tab&vocab=9\">";

		
		/* If RTC isn't installed, don't display Message Macros  > 40, just exit  */
		if($rtc == 'no'){
			if($row['command'] == '*2103' && $counter > 40) {
				exit();	
			}
		}								
		} elseif($row['command'] == '*8004' || $row['command'] == '*8005' || $row['command'] == '*8006' ) {
				print "<a href=\"editport.php?port=$port&id=$row[id]&tab=$tab&vocab=15\">";
		} else {			
				print "<a href=\"editport.php?port=$port&id=$row[id]&tab=$tab\">";
		}
		/* If RTC isn't installed, don't display DTMF Memories > 20, just exit  */
		if($rtc == 'no'){
			if($row['command'] == '*2105' && $counter > 20) {
			exit();	
		}
	}
						
	if($row['changed']){
		print '<B>';	
		print '<div class="red">' . $row['command']. ' ' . $row['sub'];	
	    print '</B></div>';	
		print "</a></td>";
	}else{			
		print " $row[command] $row[sub]";		    	
		print "</a></td>";
	}
	
	
			
			if($row['changed']){				
				print'<td><B><div class="red">'. $row['description'];
				print'</td></div>';
			}else{
				print"<td>$row[description]</td>";
			}
			print "<td>";
		
		if( $row['cdata'] == ""){
				
				if($row['changed']){ 
										
					print '<B><div class="red">NOT SET</B>';
				}else{
					print "<B>NOT SET</B>";
				}
			} else {
				if($row['command'] == '*2092' && strlen($row['cdata']) < 2){$row['cdata'] = "0" . $row['cdata'];}
				if($row['command'] == '*2101' && strlen($row['cdata']) < 2){$row['cdata'] = "0" . $row['cdata'];}
				if($row['command'] == '*2102' && strlen($row['cdata']) < 2){$row['cdata'] = "0" . $row['cdata'];}
				if($row['command'] == '*2118' && strlen($row['cdata']) < 2){$row['cdata'] = "0" . $row['cdata'];}
							
				if($row['command']=="*2064" or $row['command']=="*2066") {
					if(substr($row['cdata'],0,1) == '0'  ){
					$row['cdata'] = "";
										
					
					
					
					if($row['changed'] == 1){
						print "<div class='red'><B>(Disabled)</B>,<div>";
					}else{
						print "<B>(Disabled)</B>";
					}
					
					
					
					
					
					
					
					
					}
				}
			
				if($row['command']=="*2064" or $row['command']=="*2066") {
					if(substr($row['cdata'],3,1) == '0'  ){
					$row['cdata'] = "";					
					}
				}
				if($row['changed']){
					print'<B><div class="red">' . $row['cdata'];
				}else{
				print "$row[cdata]";
				}
				
			}
		
	if( substr($row['description'],0,7) == "CW ID #") {
		$d =  str_replace(  " ", "", $row['cdata'] );
		$l = strlen($d);
		print "<BR><B>(";
		for ($p = 0; $p < $l ; $p+=2){
			$funct = substr($d,$p,2);			
			$lookupquery = "select * from cw where code = $funct";
			$lu = safe_query($lookupquery);
			$lookup=mysqli_fetch_array($lu);
			print $lookup['letter'] . " ";
		}
		print ")</B>";
	}	
		
	if(  (substr($row['description'],0,7) == "Initial" || substr($row['description'],0,7) == "Pending"|| $row['command']=="*2103") && $row['cdata'] != "" && $row['command'] != '*1002' && $row['command'] != '*1003' && $row['command'] != '*1019') {
			$d =  str_replace(  " ", "", $row['cdata'] );
			$l = strlen($d);
			print "<BR><B>(";
			for ($p = 0; $p < $l ; $p+=3){
				$funct = substr($d,$p,3);
				$lookupquery = "select * from vocab where id = $funct";
				$lu = safe_query($lookupquery);
				$lookup=mysqli_fetch_array($lu);
				print $lookup['word'] . " ";
				$dvrquery="select * from DVRtracks where vocabnum = $funct";
				$dvrresult=safe_query($dvrquery);
				$dvrrow=mysqli_fetch_array($dvrresult);
				print "$dvrrow[contents]";					
			}
			print ")</B>";
	}
	
		if(( $row['command']=="*2083") && $row['cdata'] != "" ) {
			print "<BR><B>(";
			if($row['cdata'] == '1'){print "Kenwood Serial";}
			if($row['cdata'] == '2'){print "Icom";}
			if($row['cdata']== '3'){
				print "Yaesu";
				$yaesu = 'yes';
			}	
			if($row['cdata'] == '4'){print "Kenwood TM-V7a";}
			if($row['cdata'] == '5'){print "Doug Hall RBI-1";}
			if($row['cdata'] == '7'){print "Kenwood TM-g707";}
			if($row['cdata'] == '8'){print "Kenwood TM-271/281";}
			if($row['cdata']== '9'){print "Kenwood TM-V71a";}			
			print ")</B>";	
		}
	
		if($row['command']=="*2084") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "NONE SELECTED";}
			if($row['cdata'] == '1'){print "FT-100";}
			if($row['cdata'] == '2'){print "FT-817/FT-897";}
			if($row['cdata'] == '3'){print "FT-847";}
			if($row['cdata']== '4'){print "FT-857";}	
			if($yaesu != 'yes'){print " - but Yaesu not currently <br>  					selected as Radio Type";}
			print ")</B>";	
		}
	
		if($row['command']=="*2090") {				
			print "<BR><B>(";
			if($row['cdata'] == '1'){print "1st Digit";}
			if($row['cdata'] == '2'){print "2nd Digit";}
			print ")</B>";
		}
	
		if($row['command']=="*2091") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Don't Allow";}
			if($row['cdata'] == '1'){print "Allow";}
			print ")</B>";
		}
		
		if($row['command']=="*2108") {				
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "NONE SET";		
				print ")</B>";
			}
		}
		
		if($row['command']=="*2109") {
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "NONE SET";		
				print ")</B>";
			}
		}
		
		if($row['command']=="*2118") {				
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "NONE SET";		
				print ")</B>";
			}
		}
	
		if($row['command']=="*5105") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "NONE SET";}	
			print ")</B>";
		}
		
		if($row['command']=="*2051") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Don't Allow Linked Ports To  Timeout Other Ports";}
			if($row['cdata'] == '1'){print "Allow Linked Ports To Timeout Other Ports";}
			print ")</B>";
		}
		
		if($row['command']=="*1021") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Active Low";}
			if($row['cdata'] == '1'){print "Active High";}
			print ")</B>";
		}
		
		if($row['command']=="*1005") {				
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "Disabled";		
				print ")</B>";
			}
		}
	
		if($row['command']=="*2111") {				
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "Disabled";		
				print ")</B>";
			}
		}
		
		if($row['command']=="*2112") {				
			if($row['cdata'] == '0'){
				print "<BR><B>(";
				print "Not Set";		
				print ")</B>";
			}
		}
		
	
	
	
		if($row['command']=="*2064") {	
				if(substr($row['cdata'],0,1) != ''){print "<BR><B>(";}
			//	print "<BR><B>(";
				if(substr($row['cdata'],0,1) == '1'){print "Volts";}
				if(substr($row['cdata'],0,1) == '2'){print "Amps";}
				if(substr($row['cdata'],0,1) == '3'){print "Watts";}
				if(substr($row['cdata'],0,1) == '4'){print "Degrees";}
				if(substr($row['cdata'],0,1) == '5'){print "MPH";}
				if(substr($row['cdata'],0,1) == '6'){print "Percent";}
				if(substr($row['cdata'],0,1) != ''){print ")</B>";}
			//	print ")</B>";
	
		}
			
//		if($row['command']=="*2066") {
//			if(substr($row['cdata'],3,1) == '0'  ){
//				print "<B>(";
//				print "Disabled";		
//				print ")</B>";
//			}
//		}
		
		
		if($row['command']=="*2088") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "After COS";}
			if($row['cdata'] == '1'){print "After CT";}
			print ")</B>";
		}
	
		if($row['command']=="*2089") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "OFF During Speech";}
			if($row['cdata'] == '1'){print "ON During Speech";}
			print ")</B>";
		}
			
		if($row['command']=="*2116") {				
			print "<BR><B>(";			
			if($row['cdata'] == '1'){print "Port 1";}
			if($row['cdata'] == '2'){print "Port 2";}
			if($row['cdata'] == '3'){print "Port 3";}
			if($row['cdata'] == '12'){print "Ports 1 & 2";}
			if($row['cdata'] == '13'){print "Ports 1 & 3";}
			if($row['cdata'] == '23'){print "Ports 2 & 3";}
			if($row['cdata'] == '123'){print "All Ports";}	
			print ")</B>";
		}
		
		if($row['command']=="*2124") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Disabled";}
			if($row['cdata'] == '1'){print "Enabled";}
			print ")</B>";
		}
				
		if($row['command']=="*2125") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Minutes";}
			if($row['cdata'] == '1'){print "Hours";}
			print ")</B>";
		}
		
		
		
		if($row['command']=="*8008") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Disabled";}
			if($row['cdata'] == '1'){print "Enabled";}
			print ")</B>";
		}
		
		if($row['command']=="*8009") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Disabled";}
			if($row['cdata'] == '1'){print "Enabled";}
			print ")</B>";
		}
		
		
		if($row['command']=="*5102") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Don't Say";}
			if($row['cdata'] == '1'){print "Say Year";}
			print ")</B>";
		}
		
		if($row['command']=="*5103") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "12 Hour Readback";}
			if($row['cdata'] == '1'){print "24 Hour Readback";}
			print ")</B>";
		}
				
		if($row['command']=="*5104") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Don't Say";}
			if($row['cdata'] == '1'){print "Say Hour";}
			print ")</B>";
		}

	if($row['command']=="*2119") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Receiver Only";}
			if($row['cdata'] == '1'){print "All Transmitter Activity";}
			print ")</B>";
		}

	if($row['command']=="*2121") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Start on COS";}
			if($row['cdata'] == '1'){print "Start on PTT";}
			print ")</B>";
		}

		if($row['command']=="*2122") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "After COS";}
			if($row['cdata'] == '1'){print "After CT Segment 1";}
			if($row['cdata'] == '2'){print "After CT Segment 2";}
			if($row['cdata'] == '3'){print "After CT Segment 3";}
			if($row['cdata'] == '4'){print "After CT Segment 4";}
			print ")</B>";	
		}

		if($row['command']=="*2123") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Speak Wind Direction in Degrees";}
			if($row['cdata'] == '1'){print "Speak Wind Direction by Compass Heading";}
	
			print ")</B>";	
		}
		
		
		if($row['command']=="*2131") {				
			$dst = substr($row['cdata'],0,2);//Month
				$wom = substr($row['cdata'],2,1); //Week of Month
			if($row['sub'] == '1'){
				print "<BR><B>(";
				if ($dst == "00"){print "Disabled";}
				if ($dst == "01"){print "January";}
				if ($dst == "02"){print "February";}
				if ($dst == "03"){print "March";}				
				if ($dst == "04"){print "April";}
				if ($dst == "05"){print "May";}
				if ($dst == "06"){print "June";}
				if ($dst == "07"){print "July";}
				if ($dst == "08"){print "August";}
				if ($dst == "09"){print "September";}
				if ($dst == "10"){print "October";}
				if ($dst == "11"){print "November";}
				if ($dst == "12"){print "December";}				
				if ($wom == "1"){print " 1st Week";}
				if ($wom == "2"){print " 2nd Week";}
				if ($wom == "3"){print " 3rd Week";}
				if ($wom == "4"){print " 4th Week";}
				if ($wom == "5"){print " 5th Week";}				
				print ")</B>";
			}			
			if($row['sub'] == '0'){
				print "<BR><B>(";
				if ($dst == "00"){print "Disabled";}
				if ($dst == "01"){print "January";}
				if ($dst == "02"){print "February";}
				if ($dst == "03"){print "March";}				
				if ($dst == "04"){print "April";}
				if ($dst == "05"){print "May";}
				if ($dst == "06"){print "June";}
				if ($dst == "07"){print "July";}
				if ($dst == "08"){print "August";}
				if ($dst == "09"){print "September";}
				if ($dst == "10"){print "October";}
				if ($dst == "11"){print "November";}
				if ($dst == "12"){print "December";}				
				if ($wom == "1"){print " 1st Week";}
				if ($wom == "2"){print " 2nd Week";}
				if ($wom == "3"){print " 3rd Week";}
				if ($wom == "4"){print " 4th Week";}
				if ($wom == "5"){print " 5th Week";}				
				print ")</B>";				
			}
		}
		
		if($row['command']=="*2132") {				
			print "<BR><B>(";
			if($row['cdata'] == '1'){print "1 AM";}
			if($row['cdata'] == '2'){print "2 AM";}	
			print ")</B>";	
		}
		
		if($row['command']=="*2133") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "NOT SET";}
			if($row['cdata'] == '1'){print "SET";}	
			print ")</B>";	
		}
		
		if($row['command']=="*2135") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Generic CW Response";}
			if($row['cdata'] == '1'){print "Voice Response";}	
			print ")</B>";	
		}
		
		if($row['command']=="*7007") {				
			print "<BR><B>(";
			if($row['cdata'] == '0'){print "Use Type 04 ISD DVR IC";}
			if($row['cdata'] == '1'){print "Use Type 05 ISD DVR IC";}
	
			print ")</B>";	
		}

	
	if( $row['command'] == "*8007" ) {
		$qry = "select * from IDextras where id = $row[cdata]";
		$extra=safe_query($qry);
		$r = mysqli_fetch_array($extra);
		print "<br> <B>$r[comment]</B>";
	}			
	if($row['comment'] != ""){
		print "			<BR>$row[comment]";
	}
		
print" </td>";

		
}
Print "	
			</table>
		</td>
	</tr>
</table>";

include("footer.php");
?>

