
<HEAD>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</HEAD>

<?php
include("global.php");

$EEPROMinfo = "";
$AP1Present = "";

//Set variable so we know if there's anything to send - 1 (or True) means no data to send
$noDataToSend ="True";

//######################################################
//# Check vars table to see if we need to send anything
//######################################################


$query="select * from vars";
$result=safe_query($query);
while($vars = mysqli_fetch_array($result)){	


//Get RTC AP1 and EEPROM status first
	if( $vars['name'] == "RTCinfo"){$RTCinfo = $vars['value'];}
	if( $vars['name'] == "EEPROMinfo"){$EEPROMinfo = $vars['value'];}
	if( $vars['name'] == "AP1Present"){$AP1Present = $vars['value'];}

	
	
	$sendserial ="";
	if($vars['name'] =="ManualDataSend")	{
		if($vars['changed'] == "1"){
			$sendserial = $vars['value'];
		}
	}
	
	if($vars['name'] =="ULP1")	{
		if($vars['changed'] == "1"){
			$sendserial = "1*9000" . $vars['value'];
		}
	}	
		
	if($vars['name'] =="ULP2")	{
		if($vars['changed'] == "1"){
			$sendserial = "2*9000" . $vars['value'];
		}
	}	
	
	if($vars['name'] =="ULP3")	{
		if($vars['changed'] == "1"){
			$sendserial = "3*9000" . $vars['value'];
		}
	}
	
	if($vars['name'] =="DTMFontime")	{
		if($vars['changed'] == "1"){
			$sendserial = "1*2106" . $vars['value'];
		}
	}
	
	if($vars['name'] =="DTMFofftime")	{
		if($vars['changed'] == "1"){
			$sendserial = "1*2107" . $vars['value'];
		}
	}	
	
	if($vars['name'] =="LOCK")	{
		if($vars['changed'] == "1"){
			$sendserial = "1*9010" . $vars['value'];
		}
	}
	
	if($vars['name'] =="TERMINATOR")	{
		if($vars['changed'] == "1"){
			$sendserial = "1*9020" . $vars['value'];
		}
	}
	
	if($vars['name'] == "RTCinfo"){
		$rtcExists = $vars['value'];
	}		
	
	if($sendserial != "") {
		$noDataToSend =="True";			
		writeserial("$sendserial\r");
		//$check = exec("./serial $comport $sendserial");
	//	print "Sent to 210 " . "$sendserial<br>";
	    checkInput($sendserial);		
		$noDataToSend ="False";		
	} //if($sendata)
	
} //end of while loop

//flag vars database entry as being sent			
//if($noDataToSend =="False"){
//	$query = "update vars set changed = 0 where changed = 1";
//	$result=safe_query($query);
//}


////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Check the supervisory command database for command requests ///
////////////////////////////////////////////////////////////////////////////////////////////////////////	
$query="select * from commands";
$result=safe_query($query);
while($row= mysqli_fetch_array($result)){		

	if($row['changed'] == "1"){
		$noDataToSend ="False";	
		$sendserial = "1" . $row['code'] . $row['sub'];		//we prepend a 1 as Supervisory commands don't care about which Port is unlocked					
		writeserial("$sendserial\r");
	    checkInput($sendserial);	

		
	//	$id = $row[id];
	//	$query = "update commands set changed = 0 where id = '$id'";
	//	$result=safe_query($query);
	//	$query="select * from commands";
	//	$result=safe_query($query);
		
	} //if($row['changed'] == "1"
}	//end of while loop
	

	
//flag commands database entry as being sent		
//if($noDataToSend =="False"){
//	$query = "update commands set changed = 0 where changed = 1";
//	$result=safe_query($query);
//}




/////////////////////////////////////////////////////////////////////
// Get Config Data and send as needed
/////////////////////////////////////////////////////////////////////

	
$query ="select * from config where (changed = 1) order by port";		
$result=safe_query($query);
while( $row = mysqli_fetch_array($result) ){	
//if remote base prefix, save for later use	


	if($row['changed'] == "1"){		
		if($row['port'] == "0"){$row['port'] ="1";}  //can't program with a Port 0 so make it Port 1
			
		//format results to send to 210			
		$port = trim($row['port']);	
		$sendserial ="";		
		if($row['cdata'] =="" && $row['command'] <>'*4003'){$row['cdata']="0";} 
		if($row['command']=='*2064' && $row['cdata'] =="Not Set"){$row['cdata']="*0*0*0*0*0*";}
		if($row['command']=='*2101' && $row['cdata'] =="0"){$row['cdata']="1";}
		if($row['command']=='*2102' && $row['cdata'] =="0"){$row['cdata']="1";}
		if($row['command']=='*2110' && $row['cdata'] =="0"){$row['cdata']="1";}
		if($row['command']=='*2113' && $row['cdata'] =="0"){$row['cdata']="1";}
		if($row['command']=='*2110' && $row['cdata'] =="0"){$row['cdata']="1";}
		if($row['command']=='*2066' && $row['cdata'] =="NOT SET"){$row['cdata']= "0";}			
		if($row['command']=='*2066' && $row['cdata'] =="0"){$row['cdata'] = "*1*0*0*0*01*";}		
		if($row['command']=='*2103' && $row['sub'] < 10 ){$row['sub'] = "0" .$row['sub'];}
		if($row['command']=='*2105' && $row['sub'] < 10 ){$row['sub'] = "0" .$row['sub'];}
		
			
         //format for Macro Functions (*4002)	
		if ($row['command']=='*4002'){
			$row['cdata'] = trim($row['cdata']);
			$row['cdata'] = str_replace(" ","*",$row['cdata']) . "*";
			$sendserial = $row['port'] . $row['command'] . $row['sub'] . "*" . $row['cdata'];
		}
		
		#format MacroCodes
		if ($row['command']=='*2050' || $row['command']=='*4005'){						
			if($row['sub'] < 10){$row['sub'] = "00" . $row['sub'];}
			if($row['sub'] > 9 && $row['sub'] < 100  ){$row['sub'] = "0" . $row['sub'];}									
		}
					
				
		//Format Courtesy Tones
		if (substr($row['command'],0,2)=='*3'){
			$row['cdata'] = str_replace(" ","*",$row['cdata']) . "*";	//sub * for space
		}

		//Format Meters and Meter Alarms
		if ($row['command']=='*2064' || $row['command']=='*2066') {
			$row['cdata'] = str_replace(" ","*",$row['cdata']) ;	//sub * for space
			$sendserial = $row['port'] . $row['command'] . $row['sub'] . "*" . $row['cdata'] ;
			$noDataToSend ="False";
			writeserial("$sendserial\r");			
		    checkInput($sendserial);
			sleep(0.1);
		}
		
		if($row['command']!='*4002' && $row['command']!='*2064' && $row['command']!='*2066'){	
			$sendserial = $row['port'] . $row['command'] . $row['sub'] . $row['cdata'] ;
		}		
		
		//now take any data from above and remove any LF or whitespace that may exist within command to be sent to RC210
		
		$sendserial = str_replace("\r\n","\n",$sendserial); //only CR to be send, no LF
		$sendserial = str_replace(" ","",$sendserial);	//no whitespace to be sent	
	//	if($row['command'] =='*2064' || $row['command'] =='*2066' ){echo "SendSerial " . "$sendserial\r";}
	

		//*****NOW ACTUALLY SEND THE FORMATTED DATA TO THE RC210******
		
		#the following deals with Message Macros depending on RTC present or no
		if($rtcExists == 'no' && $row['command'] =='*2103' && $row['sub'] < '41'){		
			$noDataToSend ="False";	
			writeserial("$sendserial\r");			
		    checkInput($sendserial);				
			
		} 
		//the following deals with Message Macro memories depending on RTC present or not
		if($rtcExists == 'yes' && $row['command'] =='*2103'){ 	
			$noDataToSend ="False";
			writeserial("$sendserial\r");		
		    checkInput($sendserial);	
		}	
		
		//the following deals with Message Macro memories depending on RTC present or not
		if($rtcExists == 'no' && $row['command'] =='*2105' && $row['sub'] < '21'){
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		} 
		//the following deals with Message Macro memories depending on RTC present or not
		if($rtcExists == 'yes' && $row['command'] =='*2105'){ 
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		}	
		
		//the following deals with Scheduler Setpoints
		if ($row['command']=='*4001'){
			$row['cdata'] = trim($row['cdata']);
			$row['cdata'] = str_replace(" ","*",$row['cdata']) . "*";
			$sendserial = $row['port'] . $row['command'] . $row['sub'] . "*" . $row['cdata'];
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);
		}
				
		//the following deals with Macros depending on EEPROM present or not
		if($EEPROMinfo == 'no' && $row['command'] =='*4002' && $row['sub'] < '91'){	
			if($row['cdata'] =='0*'){$sendserial = str_replace("*4002","*4003",$sendserial);}			
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		} 
		//the following deals with Macros depending on EEPROM present or not
		if($EEPROMinfo == 'yes' && $row['command'] =='*4002' || $row['command'] == '*4003'){ 
			if($row['cdata'] =='0*'){$sendserial = str_replace("*4002","*4003",$sendserial);}			
			$noDataToSend ="False";	
			writeserial("$sendserial\r");		
		    checkInput($sendserial);			
		}		
				
		//the following deals with Macros Port Allow depending on EEPROM present or not
		if($EEPROMinfo == 'no' && $row['command'] =='*4005' && $row['sub'] < '91'){					
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		} 
		//the following deals with Macros Port Allow depending on EEPROM present or not
		if($EEPROMinfo == 'yes' && $row['command'] =='*4005'){ 			
			$noDataToSend ="False";	
			writeserial("$sendserial\r");		
		    checkInput($sendserial);			
		}		
						
		//the following deals with MacroCodes depending on EEPROM present or not
		if($EEPROMinfo == 'no' && $row['command'] =='*2050' && $row['sub'] < '91'){			
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		} 
		//the following deals with MacroCodes depending on EEPROM present or not
		if($EEPROMinfo == 'yes' && $row['command'] =='*2050'){ 
			$noDataToSend ="False";	
			writeserial("$sendserial\r");		
		    checkInput($sendserial);
			Sleep(0.1);
		}
			
		//if not dealing with Message Macros, DTMF memories or MacroCodes, send regardless of RTC and EEPROM status
		if	(	$row['command'] !='*2103' 
				&& $row['command'] !='*2105' 
				&& $row['command'] !='*2050' 
				&& $row['command'] !='*2064' 
				&& $row['command'] !='*2066'
				&& $row['command'] !='*4001'
				&& $row['command'] !='*4002'
				&& $row['command'] !='*4003'
				&& $row['command'] !='*4005'
				&& $row['command'] !='*2060'
				#the following are all AP1 codes and are handled later
				&& $row['command'] !='*1024'
				&& $row['command'] !='*1025'
				&& $row['command'] !='*2052'
				&& $row['command'] !='*2053'
				&& $row['command'] !='*2054'
				&& $row['command'] !='*2055'
				&& $row['command'] !='*2056'
				&& $row['command'] !='*2057'
				)
			{ 
				$noDataToSend ="False";
				writeserial("$sendserial\r");
				checkInput($sendserial);
				sleep(0.1);
		}
	} // if($row['changed'] == "1")
		


	
} //while loop


  //flag config database entry as being sent
 // if($noDataToSend =="False"){
//	 $query = "update config set changed = 0 where changed = 1";
//	$result=safe_query($query);
//  }

//###############################################################################
//#################NOW DEAL WTIH REMOTE BASE
//################################################################################

//first get prefix
$query ="select * from config where command = '*2060'";		
$result=safe_query($query);	
$sendserial = $row['port'] . $row['command'] . $row['cdata'];	
writeserial("$sendserial\r");		
checkInput($sendserial);





$query ="select * from remote where (changed = '1') order by memory";		
$result=safe_query($query);
while( $row = mysqli_fetch_array($result) ){	

					
		//format results to send to 210	
		//1st do the frequency info
		$freq = str_replace(".","",$row['freq']);		
		$sendserial = "1**" . "2221" . $freq . $row['offset']; //we use 222 to replace remote base prefix when programming the 210 serially
		if($rtcExists == 'yes'){ //send all
			$noDataToSend ="False";
			writeserial("$sendserial\r");		
		    checkInput($sendserial);
		}	
		if($rtcExists == 'no' && $row['memory'] < '11'){
			$noDataToSend ="False";	
			writeserial("$sendserial\r");		
		    checkInput($sendserial);
		}	
		
		//now do ctcss code and state
		$ctcss = $row['ctcss'];
		if(strlen($row['ctcss']) < 2){$row['ctcss'] = "0" . $row['ctcss'];}
		$ctcssmode = $row['ctcssmode'];
		$sendserial = "1**" . "2222" . $ctcss . $ctcssmode;
	//	echo "CTCSS " . "$serialstring\r\n";
		if($rtcExists == 'yes'){ //send all
			$noDataToSend ="False";
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		}	
		if($rtcExists == 'no' && $row['memory'] < '11'){
			$noDataToSend ="False";	
			writeserial("$sendserial\r");	
		    checkInput($sendserial);
		}	
		
		//now mode
		$opmode = $row['opmode'];
		$sendserial = "1**" . "2223" . $opmode; 
	//	echo "OPMode " . "$serialstring\r\n";
		if($rtcExists == 'yes'){ //send all
			$noDataToSend ="False";
			writeserial("$sendserial\r");	
		    checkInput($sendserial);	
		}	
		if($rtcExists == 'no' && $row['memory'] < '11'){
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
			checkInput($sendserial);
		}	
		
		//finally, store memory info
		if(strlen($row['memory']) < 2){$row['memory'] = "0" . $row['memory'];}
		$sendserial = "1*2086" . $row['memory'];
		if($rtcExists == 'yes'){ //send all
			$noDataToSend ="False";
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		}	
		if($rtcExists == 'no' && $row['memory'] < '11'){
			$noDataToSend ="False";	
			writeserial("$sendserial\r");
		    checkInput($sendserial);	
		}			

} //while

  //flag remote database entry as being sent
//if($noDataToSend =="False"){
// $query = "update remote set changed = 0 where changed = 1";
//	$result=safe_query($query);
//}		
	

//###############################################################################
//#################    NOW DEAL WTIH AUTOPATCH IF INSTALLED    ##################
//###############################################################################


$query ="select * from config where (changed = 1) order by port";		
$result=safe_query($query);
while( $row = mysqli_fetch_array($result) ){
	
	if($row['port'] == "0"){$row['port'] ="1";}  //can't program with a Port 0 so make it Port 1
	
	if($AP1Present == "yes"){	
		$sendserial = $row['port'] . $row['command'] . $row['sub'] . $row['cdata'] ;
			//take any data from above and remove any LF or whitespace that may exist within command to be sent to RC210		
		$sendserial = str_replace("\r\n","\n",$sendserial); //only CR to be send, no LF
		$sendserial = str_replace(" ","",$sendserial);	//no whitespace to be sent	
		
		if	(	$row['command'] =='*1024' 				
				|| $row['command'] =='*1025'
				|| $row['command'] =='*2052'
				|| $row['command'] =='*2053'
				|| $row['command'] =='*2054'
				|| $row['command'] =='*2055'
				|| $row['command'] =='*2056'
				|| $row['command'] =='*2057')
			{ 
				$noDataToSend ="False";			
				writeserial("$sendserial\r");			
				checkInput($sendserial);			
		}	
	}
}







	
print "<table align=\"center\" border=1 cellspacing=0 cellpadding=4>
	<tr><TD class=\"titlebar\"><B>
	
	Manual Data Send</B></TD></tr><BR><BR>"	;
	print"<td class=\"dialog\">
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4>";
	

if($noDataToSend =='True'){

	
	print "<CENTER><H2>There was no data to send.</H2></CENTER>";
}else{
	print "<CENTER><H2>Controller sucessfully updated.</H2></CENTER>";
//	writeserial = "1*219999";
//	writeserial("$sendserial\r");
}

	include("footer.php");

function checkInput($passedinfo){

$timediff = 0;	
$read = "";
$errorcount = 0;

echo "CommandSent " . "$passedinfo\r\n";	

	$starttime = microtime(true);	
	while($read =="" && $timediff < '5'){	
		
		RECHECK:
		If($errorcount >=3){	
			print"<CENTER><H2>We encountered an error when sending $read". "Please close window and try again</H2></CENTER>";	
			$noDataToSend ="False";	
			exit();
		}
		
		$read = readserial($passedinfo);	
		if($read != ""){echo "checkInput " . "$read\r\n";}  #for testing purposes
		
		if(substr($read,0,1) =="-"){			
			Sleep(0.1); 
			writeserial("$passedinfo\r"); #resend last sent command that caused NACK
			echo "Resent " . "$passedinfo\r\n";
			$errorcount++;
			echo "ErrorCount " . "$errorcount\r\n";
			Sleep(1.0);
			goto RECHECK;
		}			
		
		$endtime = microtime(true);
		$timediff = $endtime - $starttime;
		if(substr($read,0,1) =="+"){   //if ACK received, reset timer
			$starttime = microtime(true);
		}else{
			if($substring !=""){echo "Substring " . "$substring\r\n";}
			
		}	
	
		if($timediff > '4'){
			print"<CENTER><H2>No response from the RC210. Please close this window, check your serial connections and try again</H2></CENTER>";	
			$noDataToSend ="False";	
			exit();
		}
		sleep(0.1);	
		
	}//while
} //end function



?>