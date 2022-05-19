<?php
include("header.php");

?>
<!--
<SCRIPT LANGUAGE=JavaScript>

function smallpopUp(url) {
myWin=window.open(url,"win",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=1,height=1');
self.name = "mainWin"; }

</SCRIPT>
-->

<?php

include("global.php");

$query="select * from vars";
$result=safe_query($query);
while( $vars = mysqli_fetch_array($result) ){	
	if( $vars['name'] == "EEPROMinfo"){$eeprom = $vars['value'];}	
}

//$query="select * from config where type like 'macro' order by sub";


$query="select m.sub, m.cdata, m.description, m.comment, m.tab, m.id,  p.cdata as ports, cd.cdata as code, m.changed as changed
		from config as m, config as p, config as cd
		where m.command = '*4002' and 
			m.sub=p.sub and 
			cd.command = '*2050' AND m.sub=cd.sub and
			p.command = '*4005'
			order by p.sub";
			
			
			
			
			
			
/*
$query="SELECT 
    m.sub
    , m.cdata
    , m.description
    , m.comment
    , m.tab
    , m.id
    , p.cdata as ports
    , cd.cdata as code
    , m.changed as changed
FROM config m
INNER JOIN config p ON p.sub = m.sub
INNER JOIN config cd ON cd.command = '*2050' AND m.sub=cd.sub
WHERE
    p.command = '*4005'
    AND m.command = '*4002'";	
*/
			
//m = *4002 entries
//p = *4005 entries
//cd = *2050 entries


$result=safe_query($query);

$c1 = "darkrow";
$c2 = "lightrow";
$cc = $c1;

/* B4A67A */


print "
<P>&nbsp;</P>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr>
	<center>Click on the Macro # to edit that Macro</center><BR>&nbsp;
		<TD class=\"titlebar\"><B>Command Macros</B>";
		if($eeprom == 'yes'){print "<B>  (Command Macros 91-105 are enabled)</B>";}		
		print "</TD>		
	</tr>
	<tr>
		<td class=\"dialog\">


			<table class=\"dialog\" align=\"center\" border=1 cellspacing=0 cellpadding=4  bordercolor=\"#ECE9C6\"> 
				<tr>
					<td><B>Macro#</B></td>		
					<td><b>Code</b></td>
					<td><b>Ports</b></td>
					<td><B>Macro Functions / Comment</B></td>
				</tr>
			";
while( $row=mysqli_fetch_array($result) ){
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}
				
				// If external EEPROM not installed, no more than 90 Macros allowed
				if($eeprom == 'no'){
					if($row['sub']  > 90) {exit();}
				}
				
				
	print "	
				<TR class=\"$cc\">
					<td align=\"center\">";
						if($row['changed']) { 
							print '<B>';
							print "<a href=\"editmacro.php?id=$row[id]\"><span class='red'>" . $row['sub'];
							print"</a></span></B>";
						}else{
							print "<a href=\"editmacro.php?id=$row[id]\">$row[sub]</a>";	
						}    
							
	print"			</td><td>";
						
					if($row['changed']){
						print '<B><span class="red">' . $row['code'];
						print'</B></span>';
					}else{
						print "$row[code]";
					}					
					
		print "			</td><td>";					
					
					if($row['changed']){
						print '<B><span class="red">' . $row['ports'];
						print'</B></span>';
					}else{
						print "$row[ports]";
					}		
		print"			</td><td>";	
					
					if($row['changed']){
						print '<B><span class="red">' . $row['cdata'];
						print'</B></span>';
					}else{
						echo "$row[cdata]";
					}
					
		if($row['cdata'] == ""){
			if($row['changed']){
				print '<B><span class="red">' . 'NONE STORED';
			}else{
				print "NONE STORED";
			}
			print "</B></span>";
		}
					
						
	if($row['comment'] != ""){		
		if($row['changed']){
			print "<BR><B><span class='red'>" . $row['comment'];
			print'</B></BR></span>';
		}else{
			print "	<BR>$row[comment]";
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

