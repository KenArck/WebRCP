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

$query="select * from cw order by letter";

$result=safe_query($query);

print "
	<table align=\"center\" border=1 cellspacing=0 cellpadding=2>
		<tr><TD><B>Num</B></TD><TD><B>Function</B></TD></tr>
	 ";
while( $row=mysqli_fetch_array($result) ){
	print "<TR>
		<td>
		
<a href=\"javascript:to_address('$row[code]');\">$row[code]</A>		
		
		
		</td>
		<td>$row[letter]</td>
		</TR>";

}
Print "	</table>";

include("footer.php");
?>

