<?php
include("global.php");

$port = $_GET['port'] ?? '' ;
$id = $_GET['id'] ?? '' ;
$eeprom = $_GET['eeprom'] ?? '' ;

$cdid =$_POST['cdid'] ?? '' ;
$portid=$_POST['portid'] ?? '' ;
$d=$_POST['d'] ?? '' ;
$code=$_POST['code'] ?? '' ;
$ports=$_POST['ports'] ?? ''  ;
$description=$_POST['description'] ?? '' ;
$comment=$_POST['comment'] ?? '' ;


$errormsg = "";

if(isset($_POST['cancel'])){
	header("Location: macros.php\n\n");	
	exit();
}

if(isset($_POST['submitted'])){
// Validate port selection
	if($ports != 1 && $ports != 2 && $ports != 3 && $ports != 12 && $ports != 13 && $ports != 23 && $ports != 123){
		$errormsg = "Error! Invalid Ports, must be some combination of 1, 2, and/or 3 and in order.";	
	}	


	// validate macro selections
	if($sub < 41){$size=15;}
	if($sub > 40 && $sub < 91){$size=6;}
	if($sub > 90){$size=20;}

	$functlist = array();	
	trim($d);
	echo $d;
	$functlist = explode (" ", $d);	
	
	$functcount = 0;
	for($i=0; $i< count($functlist) ; $i++){
		//Function Count (slots used) depends on Macro Function #
		if($functlist[$i] < 255){$functcount++;}
		if($functlist[$i] > 254 && $functlist[$i] < 510){$functcount+=2;}
		if($functlist[$i] > 510 && $functlist[$i] < 765){$functcount+=3;}
		if($functlist[$i] > 765 && $functlist[$i] < 1020){$functcount+=4;}		
		if($functlist[$i] > 1005) {$errormsg = "Invalid Macro function ($functlist[$i])";} //If Function # is over range	
	}
		
	if($functcount > $size){
		$errormsg = "You have too many functions for this Macro! This Macro can hold a maximum of $size Functions. You have $functcount";
	}
		
	if($errormsg == ""){
	// macro
		$d = trim($d);
		$query = "update config 
				set cdata = '$d', comment='$comment', changed = 1
				where id = $id";				
		$result=safe_query($query);
	
	// code
		$query = "update config 
				set cdata = '$code', comment='$comment', changed = 1
				where id = $cdid";
		$result=safe_query($query);	
	
	// ports
		$query = "update config 
				set cdata = '$ports', comment='$comment', changed = 1
				where id = $portid";
		$result=safe_query($query);
	
	
		header("Location: macros.php\n\n");
		exit();
	}
}
if(isset($_POST['refresh'])){
	$d = trim($d);
	$query = "update config 
			set cdata = '$d', comment='$comment', changed = 1
			where id = $id";
	$result=safe_query($query);
}

include("header.php");
?>
<SCRIPT LANGUAGE=JavaScript>
<!--
function open_funct() { 
  var nwin = window.open("macrofunctions.php","functpopup","width=370,height=600,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;
}
// -->
</SCRIPT>


<P>&nbsp;</P>

<?php

// are we recycling because of an error or just getting here??
if($errormsg == ""){
	
	$query="select m.sub, m.cdata, m.description, m.comment, m.tab, m.id, p.id as portid, p.cdata as ports, cd.cdata as code, cd.id as cdid
		from config m, config p, config cd
		where m.command = '*4002' and 
			m.sub=p.sub and 
			cd.command = '*2050' AND m.sub=cd.sub and
			p.command = '*4005' AND
			m.id=$id";	

			
	$result=safe_query($query);
	$row=mysqli_fetch_array($result);
} else {
// It was an error so use our data
	$row[id]=$id;
	$row[cdid]=$cdid;
	$row[portid]=$portid;
	$row[cdata]=trim($d);
	$row[sub]=$sub;
	$row[code]=$code;
	$row[ports]=$ports;
	$row[description]=$description;
	$row[comment]=$comment;
	print "<div align=\"center\"><B class=\"errormsg\">$errormsg</B></div>";
}

if($row['sub'] < 41){$macrosize = 15;}
if($row['sub'] > 40 && $row['sub'] < 91){$macrosize = 6;}
if($row['sub'] > 90){$macrosize = 20;}


print "
<form name=\"editmac\" action=\"editmacro.php?id=$id\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>Edit Macro</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	print "		
				<TR>
					<td><B>Macro #:</B></td>
					<td>$row[sub]&nbsp;&nbsp;&nbsp;<B>Max Size: </B>$macrosize functions</td>
				</tr><tr>
					<td><B>Functions:</B></td>
					<td><input type=\"text\" name=\"d\" value=\"$row[cdata]\" size=\"50\" >";
?>
<SCRIPT LANGUAGE=JavaScript>
<!--
 document.write("<input type=button value=\"Lookup\" onclick='javascript:open_funct();'>");            
// -->
</SCRIPT>

<?php
	print "			
					</td>
				</tr><TR>
					<td>
						<B>DTMF Code:</B>
					</td>
					<td>
						<input type=\"text\" name=\"code\" value=\"$row[code]\" size=\"10\" maxlength=\"8\">					
					</td>
				</tr><TR>
					<td>
						<B>Ports:</B>
					</td>
					<td>\n";
						DynamicInput("1;2;3;12;13;23;123","1;2;3;1 & 2;1 & 3;2 & 3;All Ports",'ports',trim($row['ports']),'','');
					
//						<input type=\"text\" name=\"ports\" value=\"$row[ports]\" size=\"10\" maxlength=\"3\">
print "				</td>
				</tr><TR>
					<td>
						<B>Comment:</B>
					</td>
					<td>
						<input type=\"text\" name=\"comment\" value=\"$row[comment]\" size=\"50\">
					</td>
				</tr><tr>
					<TD colspan=2>
						<input type=\"hidden\" value=\"$row[sub]\" name=\"sub\">
						<input type=\"hidden\" value=\"$row[cdid]\" name=\"cdid\">
						<input type=\"hidden\" value=\"$row[portid]\" name=\"portid\">
						<input type=\"submit\" value=\"Save\" name=\"submitted\">					
						<input type=\"submit\" value=\"Refresh\" name=\"refresh\">
						<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >
					</TD>
				</TR>	";

Print "		</table>
		</td>
	</tr>
</table>
</form>";
$fc = countfunct($row['cdata']);

print "
<table align=\"center\">
	<tr>
		<td colspan=2><B>Function space used is $fc slots of an available $macrosize</B></td>
	</tr>
	<tr>
		<td colspan=2><table align=\"center\">";
			$func = explode(" ", $row['cdata']);// str_replace(" ", "", $row['cdata'] );		
		
		
			for ($p = 0; $p < count($func) ; $p++){
				print "<TR><TD>\n";	
				$funct = $func[$p];
				print "<B> $funct </b>";
				if($funct != ""){
				$lookupquery = "select * from mfunctions where id = $funct";
				$lu = safe_query($lookupquery);
				$lookup=mysqli_fetch_array($lu);
				}
				print "</td><td>\n";
				if($funct > 125 && $funct < 146){	// dvr track, lookup contents
					$dvrnum = $funct - 125;
					$dvrquery="select * from DVRtracks where dvrnum = $dvrnum";
					$dvrresult=safe_query($dvrquery);
					$dvrrow=mysqli_fetch_array($dvrresult);
					print "DVR-$dvrrow[dvrnum]:$dvrrow[contents]";					
				} else {
					print $lookup['description'];
				}
				print "</TD></TR>";				 
			}
			print "</table>
		</td>
	</tr>
</table>";


include("footer.php");





function countfunct ($flist = "")
{
	$cleanstring = preg_replace("/\s+/"," ",$flist);
	$flist = $cleanstring;
	$functlist = array();
	trim($flist);
	$functlist = explode (" ", $flist);
	$functcount = 0;
	for($i=0; $i< count($functlist) ; $i++){
		if($functlist[$i] < 255){$functcount++;}
		if($functlist[$i] > 254 && $functlist[$i] < 510){$functcount+=2;}
		if($functlist[$i] > 510 && $functlist[$i] < 765){$functcount+=3;}
		if($functlist[$i] > 765 && $functlist[$i] < 1020){$functcount+=4;}	
	}
	return $functcount;
}




?>

