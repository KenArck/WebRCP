<?php
include("header.php");
include("global.php");

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


$query="select * from remote order by memory";

$result=safe_query($query);

$c1 = "darkrow";
$c2 = "lightrow";
$cc = $c1;

print "
<P>&nbsp;</P>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4>

	<tr>
	<center>Click on the memory # to edit that memory</center><BR>&nbsp;
		<TD class=\"titlebar\"><B>Remote Base Memories</B>";
		if($rtc == 'yes'){print "<B>  (additional RTC memories are enabled)</B>";}		
		print "</TD>		
	</tr>
	<tr>
		<td class=\"dialog\">
					
				<table class=\"dialog\" align=\"center\" border= 1 cellspacing=0 cellpadding=4 bordercolor=\"#ECE9C6\"> 
				<tr>
					<td><B>Memory#</B></td>		
					<td><B>Description</b></td>
					<td><B>Frequency</b></td>
					<td><b>Offset</b></td>
					<td><b>CTCSS</b></td>
					<td><b>CTCSS Mode</b></td>
					<td><b>Op Mode</b></td>	
					<td><b>Comment</b></td>
				</tr>";
				
while( $row=mysqli_fetch_array($result) ){
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}
	
	print "	
				<TR class=\"$cc\">
					<td align=\"center\">";
						if($row['changed']){print "<B>";
							print"<a href=\"editremote.php?memory=$row[memory]&port=$port&tab=$tab\"><span class='red'>" . $row['memory'];
							print"</B></span>";
						}else{
							print"<a href=\"editremote.php?memory=$row[memory]&port=$port&tab=$tab\">$row[memory]";
						}
					
						
						
					print"</a></td><td>";	
					
					
					
					if($row['changed']){
						print"<B><span class='red'>" . $row['description'];
						print"</B></span>";
					}else{
						print"	$row[description]";
					}
							
	print "	   	</td><td>";
					
					if($row['changed']){
						print"<B><span class='red'>" . $row['freq'];
						print"</B></span>";
					}else{
						print"	$row[freq]";
					}			
					
					
		print"			</td>";
					
					$tempoffset = $row['offset'];
					if($row['offset'] == '1'){$templabel= "<BR><b>(Minus)</b>";}
					if($row['offset'] == '2'){$templabel ="<BR><b>(Simplex)</b>";}
					if($row['offset'] == '3'){$templabel ="<BR><b>(Plus)</b>";}
					$tempdisplay = $tempoffset . $templabel;
					
					if($row['changed']){
						print"<td><span class='red'><B>" . $tempdisplay;
						print "</td></B></span>";
					}else{
						print"<td> $tempdisplay </td>";
					}
			
				
					$temptone= $row['ctcss'];
					if($row['ctcss'] == '01'){$templabel= "<BR><b>(67.0 Hz)</b>";}
					if($row['ctcss'] == '02'){$templabel= "<BR><b>(69.3 Hz)</b>";}	
					if($row['ctcss'] == '03'){$templabel= "<BR><b>(71.9 Hz)</b>";}
					if($row['ctcss'] == '04'){$templabel= "<BR><b>(74.4 Hz)</b>";}
					if($row['ctcss'] == '05'){$templabel= "<BR><b>(77.0 Hz)</b>";}
					if($row['ctcss'] == '06'){$templabel= "<BR><b>(79.7 Hz)</b>";}
					if($row['ctcss'] == '07'){$templabel= "<BR><b>(82.5 Hz)</b>";}	
					if($row['ctcss'] == '08'){$templabel= "<BR><b>(85.4 Hz)</b>";}
					if($row['ctcss'] == '09'){$templabel= "<BR><b>(88.5 Hz)</b>";}
					if($row['ctcss'] == '10'){$templabel= "<BR><b>(91.5 Hz)</b>";}
					if($row['ctcss'] == '11'){$templabel= "<BR><b>(94.8 Hz)</b>";}		
					if($row['ctcss'] == '12'){$templabel= "<BR><b>(97.4 Hz)</b>";}
					if($row['ctcss'] == '13'){$templabel= "<BR><b>(100.0 Hz)</b>";}
					if($row['ctcss'] == '14'){$templabel= "<BR><b>(103.5Hz)</b>";}
					if($row['ctcss'] == '15'){$templabel= "<BR><b>(107.2 Hz)</b>";}
					if($row['ctcss'] == '16'){$templabel= "<BR><b>(110.9 Hz)</b>";}
					if($row['ctcss'] == '17'){$templabel= "<BR><b>(114.8 Hz)</b>";}
					if($row['ctcss'] == '18'){$templabel= "<BR><b>(118.8 Hz)</b>";}
					if($row['ctcss'] == '19'){$templabel= "<BR><b>(123.0 Hz)</b>";}
					if($row['ctcss'] == '20'){$templabel= "<BR><b>(127.3 Hz)</b>";}
					if($row['ctcss'] == '21'){$templabel= "<BR><b>(131.8Hz)</b>";}		
					if($row['ctcss'] == '22'){$templabel= "<BR><b>(136.5 Hz)</b>";}
					if($row['ctcss'] == '23'){$templabel= "<BR><b>(141.3 Hz)</b>";}
					if($row['ctcss'] == '24'){$templabel= "<BR><b>(146.2Hz)</b>";}
					if($row['ctcss'] == '25'){$templabel= "<BR><b>(151.4 Hz)</b>";}
					if($row['ctcss'] == '26'){$templabel= "<BR><b>(156.7 Hz)</b>";}
					if($row['ctcss'] == '27'){$templabel= "<BR><b>(162.2 Hz)</b>";}
					if($row['ctcss'] == '28'){$templabel= "<BR><b>(167.9 Hz)</b>";}
					if($row['ctcss'] == '29'){$templabel= "<BR><b>(173.8 Hz)</b>";}
					if($row['ctcss'] == '30'){$templabel= "<BR><b>(179.9 Hz)</b>";}
					if($row['ctcss'] == '31'){$templabel= "<BR><b>(186.2 Hz)</b>";}		
					if($row['ctcss'] == '32'){$templabel= "<BR><b>(192.8 Hz)</b>";}
					if($row['ctcss'] == '33'){$templabel= "<BR><b>(203.5 Hz)</b>";}
					if($row['ctcss'] == '34'){$templabel= "<BR><b>(206.5Hz)</b>";}
					if($row['ctcss'] == '35'){$templabel= "<BR><b>(210.7 Hz)</b>";}
					if($row['ctcss'] == '36'){$templabel= "<BR><b>(218.1 Hz)</b>";}
					if($row['ctcss'] == '37'){$templabel= "<BR><b>(225.7 Hz)</b>";}
					if($row['ctcss'] == '38'){$templabel= "<BR><b>(229.1 Hz)</b>";}
					if($row['ctcss'] == '39'){$templabel= "<BR><b>(233.6 Hz)</b>";}	
					if($row['ctcss'] == '40'){$templabel= "<BR><b>(241.8Hz)</b>";}		
					if($row['ctcss'] == '41'){$templabel= "<BR><b>(250.3 Hz)</b>";}
					if($row['ctcss'] == '42'){$templabel= "<BR><b>(254.1 Hz)</b>";}
					$tempdisplay= $temptone . $templabel;
					
					
					
					
					if($row['changed']){
						print"<td><span class='red'><B>" . $tempdisplay;
						print "</td></B></span>";
					}else{
						print"<td> $tempdisplay </td>";
					}
				
					$tempmode = $row['ctcssmode'];
					if($row['ctcssmode'] == '0'){$templabel= "<BR><b>(OFF)</b>";}
					if($row['ctcssmode'] == '1'){$templabel ="<BR><b>(Encode)</b>";}
					if($row['ctcssmode'] == '2'){$templabel ="<BR><b>(Encode/Decode)</b>";}
					$tempdisplay= $tempmode . $templabel;
					if($row['changed']){
						echo"<td><span class='red'><B>" .  $tempdisplay;
						print "</td></B></span>";
					}else{
						echo"<td> $tempdisplay </td>";
					}	

					$tempmode = $row['opmode'];
					if($row['opmode'] == '1'){$templabel= "<BR><b>(LSB)</b>";}
					if($row['opmode'] == '2'){$templabel ="<BR><b>(USB)</b>";}
					if($row['opmode'] == '3'){$templabel ="<BR><b>(CW)</b>";}
					if($row['opmode'] == '4'){$templabel ="<BR><b>(FM)</b>";}
					if($row['opmode'] == '5'){$templabel ="<BR><b>(AM)</b>";}
					$tempdisplay= $tempmode . $templabel;
					if($row['changed']){
						echo"<td><span class='red'><B>" . $tempdisplay;
						print "</td></B></span>";
					}else{
						echo"<td> $tempdisplay </td>";
					}
					
print"  			<td>";
					if($row['changed']){
						echo"<span class='red'><B>" . $row['comment'];
						print "</td></B></span>";
					}else{
						echo" $row[comment] ";
					}
	print"				</td>
				</TR>";
}
Print "	
			</table>
		</td>
	</tr>
	
</table>";




include("footer.php");
?>