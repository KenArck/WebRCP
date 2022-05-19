<?php
include("global.php");

$port = $_GET['port'] ?? '' ;
$id = $_GET['id'] ?? '' ;
$vocabnum = $_POST['vocabnum'] ?? '' ;
$contents = $_POST['contents'] ?? '' ;
$filename = $_POST['filename'] ?? '' ;



if(isset($_POST['cancel'])){
	header("Location: dvr.php\n\n");
	exit();
}

if(isset($_POST['submitted'])){
	$query = "update DVRtracks 
			set contents = '$contents', 
			filename='$filename'
			where dvrnum = $id";
	$result=safe_query($query);
	header("Location: dvr.php\n\n");
	exit();
}

include("header.php");
?>
<SCRIPT LANGUAGE=JavaScript>
<!--
function open_funct() { 
  var nwin = window.open("macrofunctions.php","functpopup","width=270,height=600,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;
}
// -->
</SCRIPT>

<?php
$query="select * from DVRtracks where dvrnum = $id";
$result=safe_query($query);

$row=mysqli_fetch_array($result);

$d =  str_replace(  " ", "", $row['cdata'] );
$l = strlen($d);
$day=substr($d,0,1);
$hour=substr($d,1,2);
$minute=substr($d,3,2);
$macro=substr($d,5,2);


print "
<P>&nbsp;</P>
<form name=\"spbuild\" action=\"editdvr.php?id=$id\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>DVR Track Point</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	print "		
				<TR>
					<td><B>DVR Track #:</B></td>
					<td>$row[dvrnum]  <B>Vocabulary Word #:</B>$row[vocabnum]</td>
				</tr>
				<tr>
					<td><B>Content:</B></td>
					<td>
						<input type=\"TEXT\" name=\"contents\" value=\"$row[contents]\" size=\"55\">
					</td>
				</tr>
				<tr>
					<td><B>Filename:</B></td>
					<td>
						<input type=\"TEXT\" name=\"filename\" value=\"$row[filename]\" size=\"55\">
					</td>
				</tr>
				<tr>
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

