<?php
/* ------------------------All this stuff gets placed before the include -------------------------
	$tabtitles=array("First Tab", "Second Tab", "Third Tab", "Fourth Tab", "Last Tab","Hello");
	$taburl=array("index.php","blah.html","blahblah.html","test.html","barf.html","s.html");
	$tabactive=3;
	$tabalign="CENTER";
	$tabwidth="80%";
-
------------------------------------------------------------------------------------------------*/

	print"<TABLE BORDER=\"0\" CELLPADDING=0 CELLSPACING=0 WIDTH=\"$tabwidth\" align=\"$tabalign\"><TR>
	<td rowspan=\"2\">&nbsp;</td>\n";
	$tabcount = count($tabtitles);
	$tabwidth = floor(100 / $tabcount);
	for( $idx = 0; $idx < $tabcount ; $idx++ ){
		if($tabactive == $idx){
			$bgc = $tabselectcolor;
			$tclass = $tabselecttextclass;
		} else {
			$bgc = $tabcolor;
			$tclass = $tabtextclass;
		}
	print "
		<TD BGCOLOR=\"$bgc\"  ALIGN=LEFT VALIGN=TOP>
			<IMG height=\"9\" src=\"images/tab-left.gif\" width=\"9\"><BR> 
		</TD>
		<TD BGCOLOR=\"$bgc\" width=\"$tabwidth%\" ROWSPAN=2 ALIGN=\"MIDDLE\">
			<A class=\"$tclass\" HREF=\"$taburl[$idx]\">$tabtitles[$idx]</A><BR>
		</TD>
		<TD BGCOLOR=\"$bgc\"  ALIGN=\"RIGHT\" VALIGN=\"TOP\">
			<IMG height=\"9\" src=\"images/tab-right.gif\" width=\"9\"><BR> 
			</TD>
		<td rowspan=\"2\">
			&nbsp;
		</td>
	";
	}
	print "</tr><tr>";
	for( $idx = 0; $idx < $tabcount ; $idx++ ){
		if($tabactive == $idx){
			$bgc = $tabselectcolor;
		} else {
			$bgc = $tabcolor;
		}
		print "
		<TD BGCOLOR=\"$bgc\">&nbsp;</TD>
		<TD BGCOLOR=\"$bgc\">&nbsp;</TD>
		";
	}
	print "</tr></table>";
?>

