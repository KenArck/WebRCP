<script language="Javascript">
    function to_address($addr) {
        var prefix    = "";
        var pwintype = typeof parent.opener.document.spbuild;

        $addr = $addr.replace(/ {1,35}$/, "");

        if (pwintype != "undefined") {
            if (parent.opener.document.spbuild.d.value) {
                prefix = " ";
                parent.opener.document.spbuild.d.value =
                    parent.opener.document.spbuild.d.value + " " + $addr;
            } else {
                parent.opener.document.spbuild.d.value = $addr;
            }
        }
    }
</script>

<?php
include("header.php");
include("global.php");


$query="select * from mfunctions order by id";

$result=safe_query($query);

print "
	<table align=\"center\" border=1 cellspacing=0 cellpadding=2>
		<tr><TD><B>Num</B></TD><TD><B>Function</B></TD></tr>
	 ";
while( $row=mysql_fetch_array($result) ){
	print "<TR>
		<td>
		
<a href=\"javascript:to_address('$row[id]');\">$row[id]</A>		
		
		
		</td>
		<td>$row[description]</td>
		</TR>";

}
Print "	</table>";

include("footer.php");
?>

