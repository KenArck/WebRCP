<?php
include("global.php");

$comment = $_POST['comment'] ?? '' ;
$memory = $_GET['memory'] ?? '' ;
$freq = $_POST['freq'] ?? '' ;
$offset= $_POST['offset'] ?? '' ;
$ctcss = $_POST['ctcss'] ?? '' ;
$ctcssmode = $_POST['ctcssmode'] ?? '' ;
$opmode = $_POST['opmode'] ?? '' ;
$tab = $_POST['tab'] ?? '' ;

if(isset($_POST['cancel'])){
	header("Location: remote.php\n\n");
	exit();
}

if(isset($_POST['submitted'])){
	$query = "update remote 
			set freq = '$freq', offset='$offset', ctcss = '$ctcss', ctcssmode = '$ctcssmode', opmode = $opmode, comment = '$comment', changed='1'
			where memory = $memory";
	$result=safe_query($query);
	header("Location: remote.php?tab=$tab\n\n");
	exit();
}


include("header.php");

$query="select * from remote where memory = $memory";

$result=safe_query($query);
$row=mysqli_fetch_array($result);

print "
<P>&nbsp;</P>
<form name=\"editremote\" action=\"editremote.php?memory=$memory\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>";


	print "$row[description]</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	
	
	print "		<TR>
					<td><B>Frequency(xxx.xxx):</B></td>
					<td><input type=\"text\" name=\"freq\" value=\"$row[freq]\" size=\"7\" >			
					<b>Must include decimal point!</B>
					</td>
				</tr>";
			
        
	  print "		<TR>
					<td>
						<B>Offset:</B>
					</td>
					<td>";
					
				DynamicInput($row['inputspecoffset'],$row['specaltoffset'],'offset',$row['offset']);	
			
print "		
					</td>
				</tr>";
				
	print"		<tr>
						<td>
						<B>CTCSS Freq:</B>
					</td>
					<td>";
					
					DynamicInput($row['inputspecctcss'],$row['specaltctcss'],'ctcss',$row['ctcss']);	
	print"
					</td>
					</tr>";
					
					
					
	print"		<tr>
						<td>
						<B>CTCSS Mode:</B>
					</td>
					<td>";
					DynamicInput($row['inputspecctcssmode'],$row['specaltctcssmode'],'ctcssmode',$row['ctcssmode']);	
	print"				
					
					</td>";
					
	print"		<tr>
						<td>
						<B>Op Mode:</B>
					</td>
					<td>";
					DynamicInput($row['inputspecopmode'],$row['specaltopmode'],'opmode',$row['opmode']);	
	print"				
					
					</td>";
	
	
	
	
	
	
	print"		<tr>
						<td>
						<B>Comment:</B>
					</td>
					<td>
						<input type=\"text\" name=\"comment\" value=\"$row[comment]\" size=\"50\">
					</td>
								
			
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
