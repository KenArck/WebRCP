<?php
include("header.php");
include("global.php");


$query="select * from DVRtracks order by dvrnum";

$result=safe_query($query);

$c1 = "darkrow";
$c2 = "lightrow";
$cc = $c1;

print "

<H2 align=\"center\" class=\"primarycolor\">DVR Track List</H2>
	<P align=\"center\">Click the DVR Track # on the left to edit.</P> 
<P>&nbsp;</P>
<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr>
		<TD class=\"titlebar\"><B>DVR Track List</B></TD>
	</tr>
	<tr>
		<td class=\"dialog\">


			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4> ";
				
while($row=mysqli_fetch_array($result)){
				if($cc == $c1){
					$cc = $c2;
				} else {
					$cc = $c1;
				}
	print "	
				<TR class=\"$cc\">
					<td align=\"center\">
						<a href=\"editdvr.php?id=$row[dvrnum]\">
						$row[dvrnum]
						</a>
					</td>
					<td>
						$row[vocabnum]
					</td>
					<td>";
					
					Print "		$row[contents]&nbsp;";
		
		
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

