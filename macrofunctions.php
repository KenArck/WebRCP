<script language="Javascript">
    function to_address($addr) {
        var prefix    = "";
        var pwintype = typeof parent.opener.document.editmac;

        $addr = $addr.replace(/ {1,35}$/, "");

        if (pwintype != "undefined") {
            if (parent.opener.document.editmac.d.value) {
                prefix = " ";
                parent.opener.document.editmac.d.value =
                    parent.opener.document.editmac.d.value + " " + $addr;
            } else {
                parent.opener.document.editmac.d.value = $addr;
            }
        }
    }
</script>

<?php
include("global.php");

?>
<HTML>
<HEAD>
	<link rel="Stylesheet" rev="Stylesheet" href="/stylesheet.css" type="text/css" media="Screen">
</HEAD>

<body leftmargin="0" topmargin="0" rightmargin="0">
<?php

$query="select * from vars";
$result=safe_query($query);
while( $vars = mysqli_fetch_array($result) ){	
	if( $vars['name'] == "EEPROMinfo"){$eeprom = $vars['value'];}	
}

$query="select * from mfunctions where id < 1020 order by id";

$result=safe_query($query);


print "
	<table align=\"center\" border=1 cellspacing=0 cellpadding=2>
		<tr><TD><B>Num</B></TD><TD><B>Function</B></TD></tr>
	 ";
while( $row=mysqli_fetch_array($result) ){
	// If external EEPROM not installed, no more than 90 Macros allowed
if($eeprom == 'no'){
	if($row['id']  > 90) {exit();}
}
	print "<TR>
		<td>
		
<a href=\"javascript:to_address('$row[id]');\">$row[id]</A>		
		
		
		</td>
		<td>$row[description]</td>
		</TR>";	
		
		
}

/*

$macroquery = "select * from config where type = 'macro' order by sub";
$macroresult = safe_query($macroquery);
while( $macrorow = mysql_fetch_array($macroresult) ){
	$mfunct = $macrorow[sub] + 700;
	if($mfunct == 765)
	{
		print "<TR><td>$mfunct</td><TD>NOT USED</TD></TR>\n";
	}
//	print $mfunct;
	if($mfunct > 764) 
	{
		$mfunct = $mfunct + 1;	
	}
		
	print "<TR><td>$mfunct</td><TD>Call Macro $macrorow[sub]  $macrorow[comment]</TD></TR>\n";
}
*/

Print "	</table>";


//include("footer.php");
?>

