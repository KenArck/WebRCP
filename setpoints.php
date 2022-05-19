<?php
include("header.php");
include("global.php");


$query="select * from config where type like 'Setpoint' order by sub";

$result=safe_query($query);

$c1 = "darkrow";
$c2 = "lightrow";
$cc = $c1;

print "
<P>&nbsp;</P>
<table align=\"center\" border=0 cellspacing=0 cellpadding=0><tr><td>
	<CENTER><H2>Scheduler Setpoints</H2></CENTER>
	Click on the Setpoint Number on the left to edit (or view the details of) the Setpoint<P>&nbsp;</P>
</td></tr></table>

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr>
		<TD class=\"titlebar\"><B>Setpoint List</B></TD>
	</tr>
	<tr>
		<td class=\"dialog\">


			<table class=\"dialog\" align=\"center\" border=1 cellspacing=0 cellpadding=4  bordercolor=\"#ECE9C6\"> 
				<tr>
					<td><B>Setpoint#</B></td>		
					<td><b>Contents</b></td>					
				</tr>
			";
				
while( $row=mysqli_fetch_array($result) ){
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}
print"		<TR class=\"$cc\"><td>";			
					
					
					if($row['changed']){						
						print "<a href=\"editsetpoint.php?id=$row[id]\"><B><span class='red'>";	
						print'</B></span>';
					}else{
						print "<a href=\"editsetpoint.php?id=$row[id]\">";
					}
											
					if($row['changed']){
						print "<B><span class='red'>" .	$row['sub'];
						print "</a></B></span>";
					}else{
						print $row['sub'];
					}
					print"</td><td>";
					
					if($row['changed']) print "<B><span class='red'>";

				if( substr($row['cdata'],5,2) == 25){
					print "DISABLED";
				}	else {		
					
				print "		$row[cdata]&nbsp;";
				}
				if($row['comment'] != ""){
					if($row[changed]){
						print "<BR><span class='red'>" . $row['comment'];	
					}else{					
						print "			<BR>$row[comment]";
					}
	}
	

		
		
print"  			</td>
				</TR>";

		
}
Print "	
			</table>
		</td>
	</tr>
</table>";




include("footer.php");
?>

