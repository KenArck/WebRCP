<?php
include("global.php");

$offtime = $_POST['offtime']?? '' ;
$id= $_GET['id'] ?? '' ;
$ontime = $_POST['ontime']?? '' ;
$level = $_POST['level']?? '' ;
$ulp1= $_POST['ulp1']?? '' ;
$ulp2= $_POST['ulp2']?? '' ;
$ulp3= $_POST['ulp3']?? '' ;
$lock= $_POST['lock']?? '' ;
$terminator= $_POST['terminator']?? '' ;
$dtmfstring= $_POST['dtmfstring']?? '' ;
$manualdatasend= $_POST['manualdatasend']?? '' ;
$comm= $_POST['comm']?? '' ;
$rtc = $_POST['rtc']?? '' ;
$eeprom = $_POST['eeprom']?? '' ;
$ap1 = $_POST['ap1']?? '' ;
$qcount = null;
$DTMFsend = null;
?>

<script  src="jquery.js"></script>

<SCRIPT LANGUAGE=JavaScript>
<!--
function open_funct() { 
  var nwin = window.open("controlserial.php","functpopup","width=320,height=300,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;		
}

function open_funct2() { 
  var nwin = window.open("completeupload.html","functpopup","width=320,height=300,resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;	
}

function open_funct3() { 
  var nwin = window.open("clockisset.html","functpopup","width=320,height=100");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;		
}

function open_funct4() { 
  var nwin = window.open("manualdatasend.html","functpopup","width=320,height=100");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;		
}
</SCRIPT>

<?php

include("header.php");

//check to see if this computer has IRLP. If not, force serial as required DTMF support scripts don't exist
$exists = file_exists('/home/irlp/scripts/decode');
if($exists != '1'){$comm = 'serial';}

/*  UPDATE VARS */
if(isset($_POST['save'])){	


//first check to see if value has changed since last save to database. If it has, set changed flag.

$query="select * from vars";
$place=safe_query($query);
while( $vars = mysqli_fetch_array($place) ){
		
		if($vars['name'] == "DTMFserial"){
			if($vars['value'] !=$comm){
		//	echo $vars[value];
		
				$query = "update vars
				set changed = '1'
				where name = 'DTMFserial'";
				$result=safe_query($query);
			}
		}		
		
		if($vars['name'] == "ULP1"){
			if($vars['value'] !=$ulp1){
				$query = "update vars
				set changed = '1'
				where name = 'ULP1'";
				$result=safe_query($query);
			}
		}

		if($vars['name'] == "ULP2"){
			if($vars['value'] !=$ulp2){
				$query = "update vars
				set changed = '1'
				where name = 'ULP2'";
				$result=safe_query($query);
			}
		}
		
		if($vars['name'] == "ULP3"){
			if($vars['value'] !=$ulp3){
				$query = "update vars
				set changed = '1'
				where name = 'ULP3'";
				$result=safe_query($query);
			}
		}
		
		if($vars['name'] == "DTMFontime"){
			if($vars['value'] !=$ontime){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'DTMFontime'";
				$result=safe_query($query);
			}
		}

		if($vars['name'] == "DTMFofftime"){
			if($vars['value'] !=$offtime){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'DTMFofftime'";
				$result=safe_query($query);
			}
		}
		
		
		if($vars['name'] == "LOCK"){
			if($vars['value'] !=$lock){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'LOCK'";
				$result=safe_query($query);
			}
		}
		
		if($vars['name'] == "TERMINATOR"){
			if($vars['value'] !=$terminator){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'TERMINATOR'";
				$result=safe_query($query);
			}
		}
		
		if($vars['name'] == "RTCinfo"){
			if($vars['value'] !=$rtc){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'RTCinfo'";
				$result=safe_query($query);
			}
		}	
		
		if($vars['name'] == "EEPROMinfo"){
			if($vars['value'] !=$eeprom){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'EEPROMinfo'";
				$result=safe_query($query);
			}
		}	
		
		if($vars['name'] == "AP1Present"){
			if($vars['value'] !=$ap1){
	//		echo $vars[value];
	//		echo $ulp1;
				$query = "update vars
				set changed = '1'
				where name = 'AP1Present'";
				$result=safe_query($query);
			}
		}	
		
		
		
		
}

  //now write values to database  	
	$query = "update vars
			set value = '$comm'
			where name = 'DTMFserial'";			
	$result=safe_query($query);
		$query = "update vars
			set value = '$ulp1'
			where name = 'ULP1'";
	$result=safe_query($query);	
	$query = "update vars
			set value = '$ulp2'
			where name = 'ULP2' ";
	$result=safe_query($query);
	$query = "update vars
			set value = '$ulp3'
			where name = 'ULP3'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$ontime'
			where name = 'DTMFontime'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$offtime'
			where name = 'DTMFofftime'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$lock'
			where name = 'LOCK'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$terminator'
			where name = 'TERMINATOR'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$rtc'
			where name = 'RTCinfo'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$eeprom'
			where name = 'EEPROMinfo'";
	$result=safe_query($query);
	$query = "update vars
			set value = '$ap1'
			where name = 'AP1Present'";
	$result=safe_query($query);
	
	
	
	
	
}


if(isset($_POST['clearflags'])){	
	$a = clearflags();
}

/* SEND ALL CHANGES NOW */
if(isset($_POST['sendnow'])){
$totalcount ="0";
$output = shell_exec('php control.php');
//the following calls a javascript at the top of this file	
	print "
<SCRIPT>	
	javascript:open_funct(); 		
</SCRIPT>
";	

}

/* Mark all records as changed FULL CONTROLLER UPLOAD */
if(isset($_POST['markall'])){
	$query = "update config
			set changed=1";
	$result=safe_query($query);
	$query = "update commands
			set changed=1";
	$result=safe_query($query);
	$query = "update vars
			set changed=1";
	$result=safe_query($query);
		$query = "update remote
			set changed=1";
	$result=safe_query($query);	

	print "
<script>
javascript:open_funct2();
</script>
";		

}
//include("header.php");


$query="select * from vars";
$result=safe_query($query);
while( $vars = mysqli_fetch_array($result) ){

	if( $vars['name'] == "DTMFserial"){$DTMFserial = $vars['value'];}
	if( $vars['name'] == "DTMFsend"){$DTMFsend = $vars['value'];}
	if( $vars['name'] == "DTMFontime"){$ontime = $vars['value'];}
	if( $vars['name'] == "DTMFofftime"){$offtime = $vars['value'];}
	if( $vars['name'] == "ULP1"){$ulp1 = $vars['value'];}
	if( $vars['name'] == "ULP2"){$ulp2 = $vars['value'];}
	if( $vars['name'] == "ULP3"){$ulp3 = $vars['value'];}	
	if( $vars['name'] == "LOCK"){$lock = $vars['value'];}	
	if( $vars['name'] == "TERMINATOR"){$terminator = $vars['value'];}	
	if( $vars['name'] == "RTCinfo"){$RTCinfo = $vars['value'];}
	if( $vars['name'] == "EEPROMinfo"){$EEPROMinfo = $vars['value'];}
	if( $vars['name'] == "AP1Present"){$AP1Present = $vars['value'];}
		
}
/* Send Manual Command */
if(isset($_POST['sendmanualdata'])){
	$query = "update vars
			set value = '$manualdatasend'					
			where name = 'ManualDataSend'";				
			$result=safe_query($query);	
			$query=		"update vars
			set changed = 1					
			where name = 'ManualDataSend'"; 					
			$result=safe_query($query);			
		/*	print"	
		<script>
javascript:open_funct4();
</script>
";*/
	$cleanstring = preg_replace ( "/[^0-9a-dsp\*\#]/i", "", $dtmfstring );
	if($DTMFserial == "serial"){
		//$command = shell_exec("php controlserial.php");
		header("Location: controlserial.php\n\n");
			
	} else {			
	//	insert code here to send manual dtmf	
	}
}

/* Set Clock */
if(isset($_POST['setclock'])){
	if($DTMFserial == "serial")	{
		$senddata = " 1*5100" . date("His\r\n");		
		$serial->sendMessage("$senddata\r");
		sleep(0.9);
		$senddata = " 1*5101" . date("mdy\r\n");		
		$serial->sendMessage("$senddata\r");			
		print "<script> 
			javascript:open_funct3();
			</script>
		";			
	} else {
	//	insert dtmf set clock here		
	}
		
}

/* Get counts from database for info message */
$query="select count(*) as chcount from config where changed <> 0";
$cnt=safe_query($query);
$countrow1 = mysqli_fetch_array($cnt);

$query="select count(*) as chcount from vars where changed <> 0";
$cnt=safe_query($query);
$countrow2 = mysqli_fetch_array($cnt);

$query="select count(*) as chcount from commands where changed <> 0";
$cnt=safe_query($query);
$countrow3 =  mysqli_fetch_array($cnt);

$query="select count(*) as chcount from remote where changed <> 0";
$cnt=safe_query($query);
$countrow4 =  mysqli_fetch_array($cnt);

$totalcount = $countrow1['chcount'] +$countrow2['chcount'] +$countrow3['chcount'] +$countrow4['chcount'];

print "<body><p id=\"p1\"><BR></BR><BR></BR><center>
		There are currently $totalcount changes waiting to be sent.</CENTER></p>";

if($exists != 'True')
{
	print "<H3><CENTER>IRLP is not installed on this computer. Serial Mode Only</B></H3></CENTER>";
}

if($DTMFsend == "yes") {
	print "<BR>A request to send has been issued";
}
 
print "
	</div>
";

print "

<form name=\"spbuild\" action=\"control.php?id=$id\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Control Settings</B></TD></tr>
	
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4 width=\"100%\">		
								
				<tr>
					<td>
						<B>Use DTMF/RS232</B>
					</td>
					<td >
						<input type=\"radio\" value=\"dtmf\" name=\"comm\"";
						if($DTMFserial == "dtmf"){ print "CHECKED"; }
						print ">Use DTMF&nbsp;&nbsp; 
						<input type=\"radio\" value=\"serial\" name=\"comm\"";
						if($DTMFserial == "serial"){ print "CHECKED"; }
						print ">Use Serial 
					</td>
				</tr>
								<tr>
					
					<td >
						<B>RTC</B>
				</td>
				<td>					  
						<input type=\"radio\" value=\"yes\" name=\"rtc\"";				
						if($RTCinfo == "yes"){ print "CHECKED"; }	
						print ">RTC Installed&nbsp;&nbsp; 
						<input type=\"radio\" value=\"no\" name=\"rtc\"";
					    if($RTCinfo == "no"){ print "CHECKED"; }	
						print ">RTC Not Installed
					</td>
				</tr>		
				
				<td >
						<B>External EEPROM</B>
				</td>
				<td>					  
						<input type=\"radio\" value=\"yes\" name=\"eeprom\"";				
						if($EEPROMinfo == "yes"){ print "CHECKED"; }	
						print ">EEPROM Installed&nbsp;&nbsp; 
						<input type=\"radio\" value=\"no\" name=\"eeprom\"";
					    if($EEPROMinfo == "no"){ print "CHECKED"; }	
						print ">EEPROM Not Installed
					</td>
				</tr>	

<td >
						<B>AP1 Autopatch</B>
				</td>
				<td>					  
						<input type=\"radio\" value=\"yes\" name=\"ap1\"";				
						if($AP1Present == "yes"){ print "CHECKED"; }	
						print ">AP1 Installed&nbsp;&nbsp; 
						<input type=\"radio\" value=\"no\" name=\"ap1\"";
					    if($AP1Present == "no"){ print "CHECKED"; }	
						print ">AP1 Not Installed
					</td>
				</tr>					
				
				
				
				
				<tr>
					<td>
						<B>DTMF Timing</B>
					</td>
					<td>
						On time <input type=\"text\" name=\"ontime\" value=\"$ontime\" size=\"5\" maxlength=\"4\">ms
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Off time <input type=\"text\" name=\"offtime\" value=\"$offtime\" size=\"5\" maxlength=\"4\">ms
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<!--		Level <input type=\"text\" name=\"level\" value=\"$level\" size=\"5\" maxlength=\"4\">% -->
					</td>
				</tr>
				<tr>
					<td>
						<B>Unlock Codes</B>
					</td>
					<td>
						Port 1 <input type=\"text\" name=\"ulp1\" value=\"$ulp1\" size=\"9\" maxlength=\"8\">
						Port 2 <input type=\"text\" name=\"ulp2\" value=\"$ulp2\" size=\"9\" maxlength=\"8\">
						Port 3 <input type=\"text\" name=\"ulp3\" value=\"$ulp3\" size=\"9\" maxlength=\"8\">						
					</td>
					<tr>
					<td>
						<B>Other Codes</B>
					</td>
					<td>
						Lock <input type=\"text\" name=\"lock\" value=\"$lock\" size=\"9\" maxlength=\"4\">					
						Terminator Digit <input type=\"text\" name=\"terminator\" value=\"$terminator\" size=\"9\" maxlength=\"1\">	
					</td>
					</tr>						
						
				<tr>
					<td colspan=2>
						<input type=\"submit\" value=\"Save Above Changes\" name=\"save\">
						
					</td>
				</tr>
				<tr>
					<td colspan=2>
					<!--	* Note: Requests to set the clock or manual DTMF sending will not be held -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>


<form  action=\"control.php\" method=\"post\">

<table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Send To RC210</B></TD></tr>
	<tr>
		<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>
				<TR>
					<td>
						<B>Manual Command String</B>
					</td>
					<td>
						<input type=\"text\" value=\"\" name=\"manualdatasend\" size=65>
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<input type=\"submit\" value=\"Send Manual Command\" name=\"sendmanualdata\" maxlength=\"250\">
						<input type=\"submit\" value=\"Update Changes Only\" name=\"sendnow\">
				        <input type=\"submit\" value=\"Send Complete Configuration\" name=\"markall\">				     	
						<input type=\"submit\" value=\"Set Clock\" name=\"setclock\">
						<input type=\"submit\" value=\"Clear Flags\" name=\"clearflags\">
					</td>
				</tr>
				<tr>
					<td colspan=2>
						
							<LI><B>Manual Data Send</B> Sends the string you entered stripping out invalid digits</LI>
							<LI><B>Update Changes Only</B> Sends only those settings that have been changed</LI>
						    <LI><B>Send Complete Configuration</B> Sends ALL settings to the controller now</LI> 
							<LI><B>Set Clock</B> Sets clock based on Linux system time (use NNTP to keep Linux accurate)</LI>
											
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
";




include("footer.php");
?>

