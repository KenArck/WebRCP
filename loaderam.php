<?php

include("global.php");
include("convert.php");

$myfile = fopen("download.mem", "r") or die("<BR><BR><BR><H2>Unable to open file!</H2>");

$count = 0;
while(!feof($myfile)) {
	
//SitePrefix - 0-3	
	$substring ="";	
	for($b = 0; $b <= 3; $b++){			
		$indata = fgets($myfile);
		$count++;		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 3 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 3){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}		
	echo "SitePrefix " . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2108'";
	$result=safe_query($query);


//TTPadTest - 4-9
$substring ="";	
for($b = 1; $b < 5; $b++){    
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$sub = chr(intval(substr($indata, $position + 1)));	
	$subsub = intval(substr($indata, $position + 1));
	if($subsub == "0" or $subsub == "255"){
		$indata = fgets($myfile);
	} else {
		$substring = $substring . $sub;}
	}	
 //   if($substring ==""){$substring ="0";} 
  //   echo "TTPadTest " . "$substring\r\n";	
	$query = "update config set cdata = $substring where command = '*2093'";
	$result=safe_query($query);

	
//SayHours - 10	
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
echo "SayHours " . "$substring\r";	
$query = "update config set cdata = $substring where command = '*5104'";
$result=safe_query($query);	
	
//HangTime1 - 11-13
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "HangTime1 Port# " . $x  . " $substring\r";
	
	$query = "update config set cdata = $substring where command = '*1000' and port = $x and sub = 1";
	
	$result=safe_query($query);
}	

//HangTime2 - 14-16
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "HangTime2 Port# " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1000' and port = $x and sub = 2";
	$result=safe_query($query);
}	
	
//HangTime3 - 17-19
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "HangTime3 Port# " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1000' and port = $x and sub = 3";
	$result=safe_query($query);
}	
	
//IIDMinutes - 20-22
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "IID1Minutes " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1002' and port = $x";
	$result=safe_query($query);
}	

//PIDMinutes - 23-25
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "PID1Minutes " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1003' and port = $x";
	$result=safe_query($query);
}

//TxEnable- 26-28
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
//	echo "TxEnable " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '111' and port = $x";
	$result=safe_query($query);
}

//DTMFCovertone - 29-31
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DTMFCovertone " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '113' and port = $x";
	$result=safe_query($query);
}

//DTMFMuteTimer - 32-37
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "DTMFMuteTimer ". $x  . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*1006' and port = $x";
	$result=safe_query($query);
}

//Kerchunk ON/OFF - 38-40
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "Kerchunk Enable " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '115' and port = $x";
	$result=safe_query($query);
}	

//KerchunkTimer - 41-46
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "KerchunkTimer ". $x  . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*1008' and port = $x";
	$result=safe_query($query);
}

//Mute Digit Select - 47
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "Mute Digit Select " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2090'";
$result=safe_query($query);	

//CTCSSDuringID - 48-50
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "CTCSSDuringID" . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2089' and port = $x";
	$result=safe_query($query);
}	

//CTCSSCTControl - 51-53
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "CTCSSCTControl" . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2088' and port = $x";
	$result=safe_query($query);
}	

//TimeoutPorts- 54
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "TimeoutPorts " .  " $substring\r";
$query = "update config set cdata = $substring where command = '*2051'";
$result=safe_query($query);

//SpeechDelay - 55-56
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$buffer1 = intval(substr($indata, $position + 1));
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$buffer2 = intval(substr($indata, $position + 1));
$substring = $buffer1 + $buffer2 * 256;
//echo "SpeechDelay ". " $substring\r\n";
$query = "update config set cdata = $substring where command = '*1019' and port = $x";
$result=safe_query($query);

//CTCSSEncodePolarity - 57-59
for($x = 1; $x <= 3; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "CTCSSEncodePolarity" . $x  . " $substring\r";
$query = "update config set cdata = $substring where command = '*1021' and port = $x";
$result=safe_query($query);
}

//GuestMacroRange - 60-66
$substring ="";	
for($b = 1; $b <=7; $b++){		
	$indata = fgets($myfile);		
	$position = strpos($indata,","); 
	$sub = chr(intval(substr($indata, $position + 1)));	
	$subsub = intval(substr($indata, $position + 1));	
	if($subsub == "0"){
		$b = 7 - $b;			
		for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
		break;
	}
	if($b < 5){$substring = $substring . $sub;}		
	 
	if($substring ==""){$substring ="0";}
	//echo "GuestMacroRange " . $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*4009' and port = $x";
	$result=safe_query($query);
}

//DTMFCOSControl - 67-69
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DTMFCOSControl" . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '122' and port = $x";
	$result=safe_query($query);
}

//DTMFEnable - 70-72
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DTMFEnable" . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '116' and port = $x";
	$result=safe_query($query);
}

//DTMFRequireTone - 73-75
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DTMFRequireTone" . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '117' and port = $x";
	$result=safe_query($query);
}


//Unlock - 76-102
for($x = 1; $x <= 3; $x++){
	$substring ="";	
	for($b = 1; $b < 9; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 9 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 9){$substring = $substring . $sub;}		
	}     
	//echo "Unlock " . $x . " $substring\r\n";	
	$query = "update vars set value = '$substring' where id = $x + 4";
	$result=safe_query($query);
}

//SpeechIDOverride - 103-105
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "SpeechIDOverride " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '118' and port = $x";
	$result=safe_query($query);
}

//CwTone1 - 106-111
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$cwtone1 = $buffer1 + $buffer2 * 256;
	if(strlen($cwtone1) < 4){$cwtone1 = "0" . $cwtone1;}	
	//echo "CWTone1 ". $x . " $cwtone1\r\n";	
	$query = "update config set cdata = $cwtone1 where command = '*8001' and port = $x";
	$result=safe_query($query);
	
}

//CwTone2 - 112-117
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$cwtone2 = $buffer1 + $buffer2 * 256;
	if(strlen($cwtone2) < 4){$cwtone2 = "0" . $cwtone2;}
//	echo "CWTone2 ". $x . " $cwtone2\r\n";
	if($cwtone2 != "0"){
		$totalcwtone = $cwtone1 . $cwtone2;
		$query = "update config set cdata = $totalcwtone where command = '*8001' and port = $x";
		$result=safe_query($query);
	}	
}

//CWSpeed - 118-120
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "CWSpeed " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*8000' and port = $x";
	$result=safe_query($query);
}

//CW1IDLength - 121-123
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$CWD1Len[$x] = $substring;	
	//echo "CW1IDLength " . $x  . " $substring\r";
	//***************don't need to store in database
}

//CW2IDLength - 124-126
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$CWD2Len[$x] = $substring;
	//echo "CW2IDLength " . $x  . " $substring\r";
	//***************don't need to store in database
}

//;ID1Length - 127-129
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$IID1Len[$x] = $substring;
	//echo "InitialID1Length " . $x  . " $substring\r";
	//***************don't need to store in database
}
	
//InitialID2Length - 130-132
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$IID2Len[$x] = $substring;
	//echo "InitialID2Length " . $x  . " $substring\r";
	//***************don't need to store in database
}

//InitialID2Length - 133-135
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$IID3Len[$x] = $substring;
	//echo "InitialID2Length " . $x  . " $substring\r";
	//***************don't need to store in database
}

//CTCSSDecode - 136-138
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "CTCSSDecode " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '112' and port = $x";
	$result=safe_query($query);
}		
	
//MonitorMix - 139-141
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "MonitorMix " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '119' and port = $x";
	$result=safe_query($query);
}		
	
//AuxAudioTimer - 142-147
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//if($substring = '255'){$substring = '0';}
	//echo "AuxAudioTimer ". $x . " $substring\r\n";
	
	if($x == 1){$query = "update config set cdata = $substring where command = '*1013'";}
	if($x == 2){$query = "update config set cdata = $substring where command = '*1014'";}
	if($x == 3){$query = "update config set cdata = $substring where command = '*1015'";}	
	$result=safe_query($query);
}	
	
//InActiveTimeout - 148-150
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "InActiveTimeout " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1005' and port = $x";
	$result=safe_query($query);
}		

//Speechoverride - 151-153
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "Speechoverride " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '120' and port = $x";
	$result=safe_query($query);
}

//EncodeTimer - 154-156
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "EncodeTimer " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1007' and port = $x";
	$result=safe_query($query);
}
	
//Repeat Mode - 157-159
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "Repeat Mode " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '114' and port = $x";
	$result=safe_query($query);
}

//TimeoutTimer - 160-165
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "TimeoutTimer ". $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*1001' and port = $x";
	$result=safe_query($query);
}	

//DTMFMute - 166-168
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DTMFMute " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '121' and port = $x";
	$result=safe_query($query);
}	
	
//AlarmEnable - 169-173
for($x = 1; $x <= 5; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "AlarmEnable " . $x  . " $substring\r";
	$query = "update commands set sub = $substring where code = '191' and port = $x";
	$result=safe_query($query);
}	
	
//AlarmMacroLow - 174-178
for($x = 1; $x <= 5; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));	
	//echo "AlarmMacroLow " . $x  . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2101' and sub = $x";
	$result=safe_query($query);
}

//AlarmMacroHigh - 179-183
for($x = 1; $x <= 5; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));	
//	echo "AlarmMacroHigh " . $x  . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2102' and sub = $x";
	$result=safe_query($query);
}		

//VREF - 184-185
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "VREF ". " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2065'";
	$result=safe_query($query);


//###########################################################################################
	///For meters, we gather all the parameters needed, then assemble them to actually store
//###########################################################################################	
	
	//MeterFaceName - 186-201
for($x = 1; $x <= 8; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$meterfacename[$x] = $buffer1 + $buffer2 * 256;
	if($meterfacename[$x] == 0){$meterfacename[$x] = 0;} //Meter OFF
	if($meterfacename[$x] == 244){$meterfacename[$x] = 1;} // Volts
	if($meterfacename[$x] == 62){$meterfacename[$x] = 2;}  //Amps
	if($meterfacename[$x] == 227){$meterfacename[$x] = 3;} //Watts
	if($meterfacename[$x] == 101){$meterfacename[$x] = 4;} //Degrees
	if($meterfacename[$x] == 150){$meterfacename[$x] = 5;} //Miles Per Hour
	if($meterfacename[$x] == 176){$meterfacename[$x] = 6;}  //Precent	
//	echo "MeterFaceName ". $x . " $meterfacename[$x]\r\n";
}

//MeterLowX - 202-217
for($x = 1; $x <= 8; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$meterlowx[$x] = $buffer1 + $buffer2 * 256;
	//echo "MeterLowX ". $x . " $meterlowx[$x]\r\n";	
}

//MeterLowY - 218-233
for($x = 1; $x <= 8; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$meterlowy[$x] = $buffer1 + $buffer2 * 256;
	//echo "MeterLowY ". $x . " $meterlowy[$x]\r\n";
}

//MeterHighX - 234-249
for($x = 1; $x <= 8; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$meterhighx[$x] = $buffer1 + $buffer2 * 256;
	//echo "MeterHighX ". $x . " $meterhighx[$x]\r\n";
}

//MeterHighY - 250-265
for($x = 1; $x <= 8; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$meterhighy[$x]  = $buffer1 + $buffer2 * 256;
	//echo "MeterHighY ". $x . " $meterhighy[$x]\r\n";
}

//*****now that we have all the parameters for programming a meter channel, format and do so
for($x = 1; $x <= 8; $x++){
	$meterstring[$x] = $meterfacename[$x] . " " . $meterlowx[$x] . " "  . $meterlowy[$x] . " " . $meterhighx[$x] . " " . $meterhighy[$x] . " ";
	//echo "Meterstring " . $x . "$meterstring[$x]\r\n";	
	$query = "update config set cdata = '$meterstring[$x]' where command = '*2064' and sub = $x";
	$result=safe_query($query);	
}

//MeterAlarmB - 266-273
for($x = 1; $x <= 8; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$meteralarmb[$x] = trim(substr($indata, $position + 1));
//echo "MeterAlarmB " . $x  . " $meteralarmb[$x]\r\n";
}		

//MeterTypeB - 274-281
for($x = 1; $x <= 8; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$metertypeb[$x] = trim(substr($indata, $position + 1));
if($metertypeb[$x] == 20){$metertypeb[$x] = 0;}
//echo "MeterTypeB " . $x  . " $metertypeb[$x]\r\n";
}

//MeterSetPoint - 282-313
for($x = 1; $x <= 8; $x++){	
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = chr(intval(substr($indata, $position + 1)));	
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer3 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer4 = chr(intval(substr($indata, $position + 1)));
	$sub = $buffer1 .= $buffer2 .= $buffer3 .= $buffer4;	
	for($b = 1; $b <= 4; $b++){
		$subdata = (unpack('f*', $sub));
	}	
	$metertrippoint[$x] = $subdata[1] * 100;	
	//echo "MeterTripPoint ". $x . " $metertrippoint[$x]\r\n";
}	

//MeterAlarmMacro - 314-321
for($x = 1; $x <= 8; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$meteralarmmacro[$x] = trim(substr($indata, $position + 1));
//echo "MeterAlarmMacro " . $x  . " $meteralarmmacro[$x]\r\n";
}

//now format data for display and sending to 210
for($x = 1; $x <= 8; $x++){
$meteralarm[$x] = "*" . $meteralarmb[$x] . "*" . $metertypeb[$x] . "*" . $metertrippoint[$x] . "*" . $meteralarmmacro[$x] . "*";

	$query = "update config set cdata = '$meteralarm[$x]' where command = '*2066' and sub = $x";
	$result=safe_query($query);
}

//RxRcvMacroActive - 322- 324
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "RxRcvMacroInactive " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2113' and port = $x and sub = 0";
	$result=safe_query($query);
}

//RxRcvMacroLow - 325-327
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "RxRcvMacroLow " . $x  . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2113' and port = $x and sub = 1";
	$result=safe_query($query);
}

//P1, P2, P3CWDI1 - 328-357
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 15; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "0" . $substring;}
		if($substring != "255" && $x <= $CWD1Len[$b]){$idstring = trim($idstring . " " .  $substring);}
		
	}
	//	echo "CWID1 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8002' and port = $b";
		$result=safe_query($query);
}

//P1, P2, P3CWD2 - 358-402
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 15; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $CWD2Len[$b]){$idstring = trim($idstring . " " .  $substring);}
	
	}
		//	echo "CWID1 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8003' and port = $b";
		$result=safe_query($query);
}


//P1, P2, P3INITIALID1 - 403-483
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $IID1Len[$b]){$idstring = trim($idstring . " " .  $substring);}
		
	}
	//	echo "INITIALID1 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8004' and port = $b and sub = 1";
		$result=safe_query($query);
}

//P1, P2, P3INITIALID2 - 484-549

for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){	
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $IID2Len[$b]){$idstring = trim($idstring . " " .  $substring);}
		
	}
	//	echo "InitialID2 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8005' and port = $b and sub = 1";
		$result=safe_query($query);
}

//P1, P2, P3INITIALID3 - 550-615

for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $IID3Len[$b]){$idstring = trim($idstring . " " .  $substring);}
		//echo "INITIALID3 " . $x  . " $idstring\r\n";
	}
		$query = "update config set cdata = '$idstring' where command = '*8006' and port = $b and sub = 1";
		$result=safe_query($query);
}

//SetPointDOW - 616-655
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$setpointdow[$x] = trim(substr($indata, $position + 1));	
//	echo "SetPointDOW " . $x  . " $setpointdow[$x]\r";
}

//SetPointMOY - 656-695
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$setpointmoy[$x] = trim(substr($indata, $position + 1));
	if(strlen($setpointmoy[$x]) < 2){$setpointmoy[$x] = "0"  . $setpointmoy[$x];}
//	If($setpointmoy[$x] == '254'){$setpointmoy[$x] = '00';}
//	echo "SetPointMOY " . $x  . " $setpointmoy[$x]\r\n";
}

//SetPointHours - 696-735
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$setpointhours[$x] = trim(substr($indata, $position + 1));
	if(strlen($setpointhours[$x]) < 2){$setpointhours[$x] = "0" . $setpointhours[$x];}
	If($setpointhours[$x] == '254'){$setpointhours[$x] = '99';}
//	echo "SetPointHours " . $x  . " $setpointhours[$x]\r\n";
}

//SetPointMinutes - 736-775
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$setpointminutes[$x] = trim(substr($indata, $position + 1));
	if(strlen($setpointminutes[$x]) < 2){$setpointminutes[$x] = "0" . $setpointminutes[$x];}
	//echo "SetPointMinutes " . $x  . " $setpointminutes[$x]\r\n";
}

//SetPointMacro - 776-815
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$setpointmacro[$x] = trim(substr($indata, $position + 1));
//	echo $x . " " . strlen($setpointmacro[$x]) . "\r\n";
	if(strlen($setpointmacro[$x]) < 2){$setpointmacro[$x] = "0"  . $setpointmacro[$x];}
//	echo "SetPointMacro " . $x  . " $setpointmacro[$x]\r\n";
}

//DoSetPoint - 816-855
for($x = 1; $x <= 40; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DoSetPoint " . $x  . " $substring\r";
	//******don't need to store this in database
}

//*****now we need to format and store setpoint data in database
for($x = 1; $x <= 40; $x++){
	$setpointstring = $setpointdow[$x] . " " . $setpointmoy[$x] . " " . $setpointhours[$x] . " " . $setpointminutes[$x]. " "  . $setpointmacro[$x];
//	echo "SetPointString " . [$x] . " " . "$setpointstring\r\n";
	$query = "update config set cdata = '$setpointstring' where command = '*4001' and sub = $x";
	$result=safe_query($query);
//	$counter++;
}

//*****Courtesy Tones
//CTTone1 - 856-875
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone1[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone1 ". $x . " $tone1[$x]\r\n";
	
}

//CTTone2 - 876-895
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone2[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone2 ". $x . " $tone2[$x]\r\n";
}

//CTTone3 - 896-915
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone3[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone3 ". $x . " $tone3[$x]\r\n";
}

//CTTone4 - 916-935
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone4[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone4 ". $x . " $tone4[$x]\r\n";
}

//CTTone5 - 936-955
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone5[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone5 ". $x . " $tone5[$x]\r\n";
}

//CTTone6 - 956-975
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone6[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone6 ". $x . " $tone6[$x]\r\n";
}

//CTTone7 - 976-995
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone7[$x] = $buffer1 + $buffer2 * 256;
//	echo "CTTone7 ". $x . " $tone7[$x]\r\n";
}

//CTTone8 - 996-1015
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$tone8[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTTone8 ". $x . " $tone8[$x]\r\n";
}

//CTDelay1 - 1016-1035
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$delay1[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDelay1 ". $x . " $delay1[$x]\r\n";
}

//CTDelay2 - 1036-1055
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$delay2[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDelay2 ". $x . " $delay2[$x]\r\n";
}


//CTDelay3 - 1056-1075
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$delay3[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDelay3 ". $x . " $delay3[$x]\r\n";
}

//CTDelay4 - 1076-1095
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$delay4[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDelay4 ". $x . " $delay4[$x]\r\n";
}

//CTDuration1 - 1096-1115
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$dur1[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDuration1 ". $x . " $dur1[$x]\r\n";
}

//CTDuration2 - 1116-1135
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$dur2[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDuration2 ". $x . " $dur2[$x]\r\n";
}


//CTDuration3 - 1136-1155
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$dur3[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDuration3 ". $x . " $dur3[$x]\r\n";
}

//CTDuration4 - 1156-1175
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$dur4[$x] = $buffer1 + $buffer2 * 256;
	//echo "CTDuration4 ". $x . " $dur4[$x]\r\n";
}

//*****now we need to format and store CT data in database
for($x = 1; $x <= 10; $x++){		
	$b = $x;
	if($x < 10){$b = "0" . $x;}
	$ctnum = "*31" . $b;
	$ctstring = $delay1[$x] . " " .  $dur1[$x] . " " . $tone1[$x] . " " . $tone2[$x];	
	//echo "CT# " . $b . " " . $ctnum . " " . "$ctstring\r\n";	
	$query = "update config set cdata = '$ctstring' where command = '$ctnum'";	
	$result=safe_query($query);	

	$ctnum = "*32" . $b;
	$ctstring = $delay2[$x] . " " . $dur2[$x]. " "  . $tone3[$x] . " " . $tone4[$x];	
	//echo "CT# " . $b . " " . $ctnum . " " . "$ctstring\r\n";
	$query = "update config set cdata = '$ctstring' where command = '$ctnum'";
	$result=safe_query($query);	
	
	$ctnum = "*33" . $b;
	$ctstring = $delay3[$x] . " " . $dur3[$x] . " " . $tone5[$x] . " " . $tone6[$x];		
	//echo "CT# " . $b . " " . $ctnum . " " . "$ctstring\r\n";
	$query = "update config set cdata = '$ctstring' where command = '$ctnum'";
	$result=safe_query($query);	
	
	$ctnum = "*34" . $b;
	$ctstring = $delay4[$x] . " " . $dur4[$x] . " " . $tone7[$x] . " " . $tone8[$x];	
	//echo "CT# " . $b . " " . $ctnum . " " . "$ctstring\r\n";
	$query = "update config set cdata = '$ctstring' where command = '$ctnum'";
	$result=safe_query($query);
}

//RadioType - 1176
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "RadioType " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2083'";
$result=safe_query($query);



//YaesuType - 1177
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "YaesuType " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2084'";
$result=safe_query($query);

//FanTimeout - 1178
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "FanTimeout " . " $substring\r";
$query = "update config set cdata = $substring where command = '*1004'";
$result=safe_query($query);

//DTMFRegenPrefix1 - 1179-1185
	
$substring ="";	
for($b = 1; $b < 7; $b++){		
	$indata = fgets($myfile);		
	$position = strpos($indata,","); 
	$sub = chr(intval(substr($indata, $position + 1)));	
	$subsub = intval(substr($indata, $position + 1));	
	if($subsub == "0"){
		$b = 7 - $b;			
		for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
		break;
	}
	if($b < 7){$substring = $substring . $sub;}		
	} 
	if($substring ==""){$substring ="0";}
	//echo "DTMFRegenPrefix2 " . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2104' and sub = 1";
	$result=safe_query($query);
	

//Clock24Hours - 1186
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "Clock24Hours " . " $substring\r";
$query = "update config set cdata = $substring where command = '*5103'";
$result=safe_query($query);


//FanSelect - 1187
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "FanSelect " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2119'";
$result=safe_query($query);


//DTMFDuration - 1188
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFDuration " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2106'";
$result=safe_query($query);

//DTMFPause - 1189
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFPause " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2107'";
$result=safe_query($query);

	
//DTMFStrings - 1190-1409
$counter="0";
for($x = 1; $x <= 20; $x++){	
	$substring ="";	
	for($b = 1; $b < 11; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if(intval($subsub == 255)){$subsub ="0";}
		if($subsub == "0"){
			$b = 11 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		
		if($b < 11){$substring = $substring . $sub;}		
	} 
		
		//if($substring ==""){$substring ="0";}
		$counter++;
		if(strlen($counter) < 2){$counter = "0" . $counter;}		
	//echo "DTMFStrings " . $x . " " . $counter . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2105' and sub = $counter";
	$result=safe_query($query);	
}


//DVRSecondLow - 1410-1473
for($x = 1; $x <= 64; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DVRSecondLow " . $x  . " $substring\r";
}	

//DVRTrack - 1474-1493
for($x = 1; $x <= 20; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DVRTrack " . $x  . " $substring\r";
}	

	
//DVRRowsUsed - 1494-1533
for($x = 1; $x <= 20; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "DVRRowsUsed ". $x . " $substring\r\n";
}	
	
//AllowTerminatorSpeech - 1534
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "AllowTerminatorSpeech" . " $substring\r";
$query = "update config set cdata = $substring where command = '*2091'";
$result=safe_query($query);

//RemoteRadioMode - 1535-1544
for($x = 1; $x <= 10; $x++){
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "RemoteRadioMode " . $x . " $substring\r";
$query = "update remote set opmode = $substring where memory = $x";
$result=safe_query($query);
}

//InactivityMacro - 1545-1550
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "InactivityMacro ". $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2114' and port = $x";
	$result=safe_query($query);
}

//AutoPatchPort - 1551
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "AutoPatchPort" . " $substring\r";
$query = "update config set cdata = $substring where command = '*2116'";
$result=safe_query($query);

//APMute - 1552
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "APMute" . " $substring\r";
$query = "update commands set sub = $substring where code = 270";
		$result=safe_query($query);

//GeneralTimers1_3 - 1553-1558
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "GeneralTimers1_3 ". $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*1017' and sub = $x";
	$result=safe_query($query);
}

//GeneralTimers4_6 - 1559-1564
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "GeneralTimers4_6 ". $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*1017' and sub = $x + 3";
	$result=safe_query($query);
}

//GeneralTimer1_3Macro - 1565-1567
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
//	echo "GeneralTimer1_3Macro " . $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2092' and sub = $x";
	$result=safe_query($query);
}
	
//GeneralTimer4_6Macro - 1568-1570
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));	
//	echo "GeneralTimer4_6Macro " . $x . " $substring\r\n";
	$query = "update config set cdata = $substring where command = '*2092' and sub = $x + 3";
	$result=safe_query($query);
}	

//ProgramPrefix - 1571-1575
	$substring ="";	
	for($b = 1; $b < 5; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 5 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 5){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	//echo "ProgramPrefix " . "$substring\r\n";
	$query = "update config set cdata = $substring where command = '*2109'";
	$result=safe_query($query);


//Phrase - 1576-1975
for($x = 1; $x <= 40; $x++){	
	$substring ="";	
	for($b = 1; $b < 10; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = intval(substr($indata, $position + 1));
		if(strlen($sub) < 2) $sub = "00{$sub}";
		if(strlen($sub) < 3) $sub = "0{$sub}";		
	//	//echo $b . " $sub\r\n";		
		$subsub = intval(substr($indata, $position + 1));
		if($subsub == "0"){	
		//	//echo "Subsub " . $b .  " $subsub\r\n";
			$b = 10 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 10 && $subsub != "0"){$substring = $substring . $sub . " ";}		
	} 
	chop($substring);	
	$phrasenum = $x;	
	if(strlen($phrasenum) < 2) $phrasenum = "0{$phrasenum}";	
//	echo "Phrase " . $phrasenum . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2103' and sub = $phrasenum";
	$result=safe_query($query);
}
	

//IDExtras - 1976-1984
for($x = 1; $x <= 9; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "IDExtras " . $x . " $substring\r";
	if($x < 4){$query = "update config set cdata = '$substring' where command = '*8007' and port = $x and sub = 1";}
	if($x > 3 && $x < 7 ){$query = "update config set cdata = '$substring' where command = '*8007' and port = $x and sub = 2";}
	if($x > 6){$query = "update config set cdata = '$substring' where command = '*8007' and port = $x and sub = 3";}	
	$result=safe_query($query);
}


//Macro - 1985-2624
$itemp ="";
for($x = 1; $x <= 40; $x++){	
	$substring ="";	
	for($b = 0; $b <= 15; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$iload[$b] = intval(substr($indata, $position + 1));	
	}	
	
	$itemp = 0;
	$a = 0;
	$substring ="";
	do{		
	//	echo "iload[" . $a . "] " .  "$iload[$a]\r\n";
		
		if($iload[$a] != 0){
			$itemp = $iload[$a];
			$a++;
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}
		}else{
			break;
		}
		$sub = $itemp;
		$substring = $substring . " " . $sub; 
	}while($a <= 15);		

	$macronum = $x;

//	echo "Macro "  . $macronum . " $substring\r\n";	
	$query = "update config set cdata = '$substring' where command = '*4002' and sub = $macronum";
	$result=safe_query($query);		

}

//MacroRecallCode - 2625-2824
$counter="0";
for($x = 1; $x <= 40; $x++){	
	$counter++;
	$macrocode ="";	
	if(strlen($counter) < 2){$counter = "0" . $counter;}	
	for($b = 1; $b <=5; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 		
		$sub = intval(substr($indata, $position + 1));
		if($sub != "0"){$converted = convertBack(chr($sub));}	
		if($sub == "0"){		
			$b = 5 - $b;				
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}		
			break;
		}
		if($converted != ""){$macrocode = $macrocode . $converted;}		
	}
	$counterstring = '*2050' . $counter;
	//echo "Macrocode " . "$macrocode\r\n";
	$query = "update config set cdata = '$macrocode' where command = '$counterstring'";	
	$result=safe_query($query);
}

//ShortMacro - 2825-3174
$itemp ="";
for($x = 1; $x <= 50; $x++){	
	$substring ="";	
	for($b = 0; $b <= 6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$iload[$b] = intval(substr($indata, $position + 1));	
	}	
	
	$itemp = 0;
	$a = 0;
	$substring ="";
	do{		
	//	echo "iload[" . $a . "] " .  "$iload[$a]\r\n";
		
		if($iload[$a] != 0){
			$itemp = $iload[$a];
			$a++;
			if($iload[$a - 1] == 255){
				$itemp = $itemp + $iload[$a];
				$a++;
			}
			if($iload[$a - 1] == 255){
				$itemp = $itemp + $iload[$a];
				$a++;
			}
			if($iload[$a - 1] == 255){
				$itemp = $itemp + $iload[$a];
				$a++;
			}
		}else{
			break;
		}
		$sub = $itemp;
		$substring = $substring . " " . $sub; 
	}while($a <= 6);

	$macronum = $x;

//	echo "ShortMacro "  . $macronum  . " $substring\r\n";
	
		$query = "update config set cdata = '$substring' where command = '*4002' and sub = $macronum + 40";
		$result=safe_query($query);		
}

//ShortMacroRecallCode - 3175-3424
for($x = 1; $x <= 50; $x++){	
	$counter++;
	$macrocode ="";	
	if(strlen($counter) < 2){$counter = "0" . $counter;}	
	for($b = 1; $b <=5; $b++){		
		$indata = fgets($myfile);	
		$position = strpos($indata,","); 		
		$sub = intval(substr($indata, $position + 1));
		if($sub != "0"){$converted = convertBack(chr($sub));}	
		if($sub == "0"){		
			$b = 5 - $b;				
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}		
			break;
		}
		if($converted != ""){$macrocode = $macrocode . $converted;}		
	
	}
	$counterstring = '*2050' . $counter;

//	echo "Macrocode " . "$macrocode\r\n";
	$query = "update config set cdata = '$macrocode' where command = '$counterstring'";	
	$result=safe_query($query);
}
$counter="0";
//MacroPortLimit - 3425-3514
for($x = 1; $x <= 90; $x++){
	$counter++;
	if(strlen($counter) < 2){$counter = "0" . $counter;}
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "MacroPortLimit " . $x . " $substring\r";
	$query = "update config set cdata = '$substring' where command = '*4005' and sub = $counter";
	$result=safe_query($query);
	}

//SpeakPendingIDTimer - 3515-3520
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "SpeakPendingIDTimer ". $x . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*1019' and port = $x";
	$result=safe_query($query);
}

//EnableSpeechID - 3521-3523
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
	//echo "EnableSpeechID - " . $x . " $substring\r";
	$query = "update config set cdata = '$substring' where command = '*8008' and port = $x";
	$result=safe_query($query);
	
}

//GuestMacroEnable - 3524
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "GuestMacroEnable - " . " $substring\r";
$query = "update commands set sub = '$substring' where code = '*280'";
$result=safe_query($query);

//RemoteBasePrefix - 3525-3530 	
	$substring ="";	
	for($b = 1; $b < 6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 6 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 6){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
		//echo "RemoteBasePrefix " . " $substring\r\n";
		$query = "update config set cdata = '$substring' where command = '*2060'";
		$result=safe_query($query);

//LockCode - 3531-3535	
	$substring ="";	
	for($b = 1; $b < 5; $b++){		
		$indata = fgets($myfile);	
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 5 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 5){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
		//echo "LockCode " . " $substring\r\n";
		$query = "update vars set value = '$substring' where id = '11'";
	    $result=safe_query($query);
		
		
		$query = "update vars set value = '$substring' where id = 11";
		$result=safe_query($query);
		
//Terminator - 3536-3537	
	$substring ="";	
	for($b = 1; $b <=2; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 2 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 2){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
		//echo "Terminator " . " $substring\r\n";		
		$query = "update vars set value = '$substring' where id = 12";
		$result=safe_query($query);
			
//ClockCorrection - 3538-3539
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "ClockCorrection ". " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*5101'";
	$result=safe_query($query);

//SayYear - 3540
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = trim(substr($indata, $position + 1));
//echo "SayYear - " . " $substring\r";
$query = "update config set cdata = '$substring' where command = '*5102'";
$result=safe_query($query);


//P1TailMessage - 3541-3543
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
	if(strlen($substring) < 2){$substring = "0"  . $substring;}
//	echo "P1TailMessage " . $x . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2110' and sub = '1' and port = $x";
	$result=safe_query($query);
}	

//P2TailMessage - 3544-3546
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
	if(strlen($substring) < 2){$substring = "0"  . $substring;}
//	echo "P2TailMessage " . $x . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2110' and sub = '2' and port = $x";
	$result=safe_query($query);
}

//P3TailMessage - 3547-3549
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
	if(strlen($substring) < 2){$substring = "0"  . $substring;}
	//echo "P3TailMessage " . $x . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2110' and sub = '3' and port = $x";
	$result=safe_query($query);
}

//TailMessageNumber - 3550-3552
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));	
	//echo "TailMessageNumber " . $x . " $substring\r";
	$query = "update config set cdata = '$substring' where command = '*2111' and port = $x";
	$result=safe_query($query);
}


//TailTimer - 3553-3558
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = intval(substr($indata, $position + 1));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = intval(substr($indata, $position + 1));
	$substring = $buffer1 + $buffer2 * 256;
	//echo "TailTimer ". " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*1020' and port = $x";
	$result=safe_query($query);
}

//TailCounter - 3559-3561
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = trim(substr($indata, $position + 1));
	//echo "TailCounter " . $x . " $substring\r";
	$query = "update config set cdata = '$substring' where command = '*2112' and port = $x";
	$result=safe_query($query);
}

//FreqString - 3562-3641	
for($x = 1; $x <= 10; $x++){
	$substring ="";	
	for($b = 1; $b <=8; $b++){		
		$indata = fgets($myfile);
	//		echo "INDATA " . "$indata\r\n";
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 8 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}		
		if($b < 8){$substring = $substring . $sub;}		
	} 
	$subfreq = substr($substring,0,3) . "." . substr($substring,3,3);
	$offset = substr($substring,6,1);
//	echo "FreqString " . "$substring\r\n";
	//	if($substring ==""){$substring ="0";}
	
//	echo "FreqString " . $x . " $subfreq\r\n";	
//	echo "OFFSET " . " $offset\r\n";
	
	$query = "update remote set freq = '$subfreq' where memory = $x";
	$result=safe_query($query);
	$query = "update remote set offset = '$offset' where memory = $x";
	$result=safe_query($query);
}


//RemoteCTCSS - 3642-3651
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "RemoteCTCSS " . $x . " $substring\r";
	$query = "update remote set ctcss = $substring where memory = $x";
	$result=safe_query($query);
	}

//CTCSSMode - 3652-3661
for($x = 1; $x <= 10; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "CTCSSMode " . $x . " $substring\r";
	$query = "update remote set ctcssmode = $substring where memory = $x";
	$result=safe_query($query);
	}

//DTMFRegenPort1 - 3662
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFRegenPort1 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2117' and sub = 1";
$result=safe_query($query);	
	

//DTMFRegenMacro1 - 3663
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = trim(substr($indata, $position + 1));
if(strlen($substring) < 2){$substring = "0"  . $substring;}
//echo "DTMFRegenMacro1 " . " $substring\r\n";
$query = "update config set cdata = $substring where command = '*2118' and sub = 1";
$result=safe_query($query);	


//APHangupCode - 3564-3669	

	$substring ="";	
	for($b = 1; $b <=6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 6 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 6){$substring = $substring . $sub;}		
	} 
	if($substring ==""){$substring ="0";}
	//echo "APHangupCode - " . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2052'";
	$result=safe_query($query);
	

//UseDR1 - 3670
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "UseDR1 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2124'";
$result=safe_query($query);	

//TimeoutResetSelect - 3671-3673
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "TimeoutResetSelect " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2122' and port = $x";
	$result=safe_query($query);	
}

//KerchunkResetTimer - 3674-3676
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "KerchunkResetTimer " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1008' and port = $x";
	$result=safe_query($query);	
}

//WindSelect - 3677
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "WindSelect " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2123'";
	$result=safe_query($query);	

//ConstantID - 3678-3680
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "ConstantID " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*8009' and port = $x";
	$result=safe_query($query);	
}
//IDOnPTT - 3681-3683
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
//	echo "IDOnPTT " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*2121' and port = $x";
	$result=safe_query($query);	
}

//TOTResetTimer - 3684-3686
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "TOTResetTimer " . $x . " $substring\r";
	$query = "update config set cdata = $substring where command = '*1009' and port = $x";
	$result=safe_query($query);	
}

//DSTFlag - 3687
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DSTFlag " . " $substring\r";
	$query = "update vars set value = $substring where name= 'DSTFlag' and id - 14";
	$result=safe_query($query);	

//DTMFRegenPrefix2 - 3688-3694
$substring = "";	
	$substring ="";	
	for($b = 1; $b < 7; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 7 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 7){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	//echo "DTMFRegenPrefix2" . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2104' and sub = 2";
	$result=safe_query($query);

//DTMFRegenPrefix3 - 3695-3701
$substring = "";	
	$substring ="";	
	for($b = 1; $b < 7; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 7 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 7){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	 //echo "DTMFRegenPrefix3 " . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2104' and sub = 3";
	$result=safe_query($query);
	
	 
//DTMFRegenPort2 - 3702
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFRegenPort2 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2117' and sub = 2";
$result=safe_query($query);	

//DTMFRegenPort3 - 3703
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFRegenPort3 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2117' and sub = 3";
$result=safe_query($query);	

//DTMFRegenMacro2 - 3704
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFRegenMacro2 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2118' and sub = 2";
$result=safe_query($query);		 
	 
//DTMFRegenMacro3 - 3705
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DTMFRegenMacro3 " . " $substring\r";
$query = "update config set cdata = $substring where command = '*2118' and sub = 3";
$result=safe_query($query);		 	 
	
//APOffHookCode - 3706-3711	
	$substring ="";	
	for($b = 1; $b <=6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 6 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 6){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	//echo "APOffHookCode " . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2053'";
	$result=safe_query($query);

//APAutoDialCode - 3712-3717	

	$substring ="";	
	for($b = 1; $b <=6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 6 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 6){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	//echo "APAutoDialCode - " . " $substring\r\n";	
	$query = "update config set cdata = '$substring' where command = '*2054'";
	$result=safe_query($query);

//APExtendTimerCode- 3718-3723	

	$substring ="";	
	for($b = 1; $b <=6; $b++){		
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));	
		$subsub = intval(substr($indata, $position + 1));	
		if($subsub == "0"){
			$b = 6 - $b;			
			for($c = 1; $c <= $b; $c++){$indata = fgets($myfile);}
			break;
		}
		if($b < 6){$substring = $substring . $sub;}		
	} 
		if($substring ==""){$substring ="0";}
	//echo "APExtendTimerCode-" . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2055'";
	$result=safe_query($query);	
	

//PendingID1Length - 3724-3726
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$PID1Len[$x] = $substring;
	//echo "PendingID1Length " . $x . " $substring\r";
	//***************don't need to store in database
}	
	
//PendingID2Length - 3727-3729
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$PID2Len[$x] = $substring;
	//echo "PendingID2Length " . $x . " $substring\r";
	//***************don't need to store in database
}

//PendingID3Length - 3730-3732
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$PID3Len[$x] = $substring;
	//echo "PendingID3Length " . $x . " $substring\r";
	//***************don't need to store in database
}

//P1, P2, P3PendingID1 - 3733-3776
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $PID1Len[$b]){$idstring = trim($idstring . " " .  $substring);}		
	}
	//	echo "PendingID1 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8004' and port = $b and sub = 2";
		$result=safe_query($query);
}


//P1, P2, P3PendingID2 - 3777-3864
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){		
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $PID2Len[$b]){$idstring = trim($idstring . " " .  $substring);}	
		
	}
	//	echo "PendingID2 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8005' and port = $b and sub = 2";
		$result=safe_query($query);
}

//P1, P2, P3PendingID3 - 3865-3930
for($b = 1; $b <=3; $b++){
	$idstring="";
	for($x = 1; $x <= 22; $x++){	
		$indata = fgets($myfile);
		$position = strpos($indata,","); 
		$substring = trim(substr($indata, $position + 1));
		if(strlen($substring) < 2){$substring = "00" . $substring;}
		if(strlen($substring) < 3){$substring = "0" . $substring;}		
		if($substring != "255" && $x <= $PID3Len[$b]){$idstring = trim($idstring . " " .  $substring);}			
	}
	//	echo "PendingID3 " . "$idstring\r\n";
		$query = "update config set cdata = '$idstring' where command = '*8006' and port = $b and sub = 2";
		$result=safe_query($query);
}

//ISDType - 3931
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
if(trim($substring) == '5'){$substring = '0';}
if(trim($substring) == '6'){$substring = '1';} 
//echo "ISDType " . " $substring\r\n";
$query = "update config set cdata = $substring where command = '*7007'";
$result=safe_query($query);	

//DVRSecondHigh - 3932-3995
for($x = 1; $x <= 64; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	//echo "DVRSecondHigh " . $x . " $substring\r";
	//***************don't need to store in database
}
	
//Total TX Uptime - 3996 - 4007
for($x = 1; $x <= 3; $x++){	
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer3 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer4 = chr(intval(substr($indata, $position + 1)));
	$sub = $buffer1 .= $buffer2 .= $buffer3 .= $buffer4;	
	for($b = 1; $b <= 4; $b++){
		$subdata = (unpack('f*', $sub));
	}	
	$TotalTxTime[$x] = $subdata[1] * 100;	
	//echo "TotalTxTime ". $x . " $TotalTxTime[$x]\r\n";
}	

//Total TX Keyups - 4008 - 4019
for($x = 1; $x <= 3; $x++){	
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer1 = chr(intval(substr($indata, $position + 1)));	
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer2 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer3 = chr(intval(substr($indata, $position + 1)));
	$indata = fgets($myfile);	
	$position = strpos($indata,","); 
	$buffer4 = chr(intval(substr($indata, $position + 1)));
	$sub = $buffer1 .= $buffer2 .= $buffer3 .= $buffer4;	
	for($b = 1; $b <= 4; $b++){
		$subdata = (unpack('f*', $sub));
	}	
	$TotalKeyUps[$x] = $subdata[1] * 100;	
	//echo "TotalKeyUps ". $x . " $TotalKeyUps[$x]\r\n";
//	$query = "update config set cdata = $substring where command = '*7007'";
//	$result=safe_query($query);
}	
	

//TxKeySelect(4020)
$indata = fgets($myfile);
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "TxKeySelect " . " $substring\r\n";
//$query = "update config set cdata = $substring where command = '*7007'";
//$result=safe_query($query);	


//RSSILow(4021 - 4023)
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$RSSILow = $substring;
	//echo "RSSILow " . $x . " $RSSILow\r";
	$query = "update config set cdata = $substring where command = '*21301' and port = $x";
	$result=safe_query($query);	
}


//RSSIHigh(4024- 4026)
for($x = 1; $x <= 3; $x++){
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
	$RSSIHigh = $substring;
	//echo "RSSIHigh " . $x . " $RSSIHigh\r";
	$query = "update config set cdata = $substring where command = '*21302' and port = $x";
	$result=safe_query($query);	
}

$counter="0";
//ExtendedMacroPortLimit - 4027-4041
for($x = 91; $x <= 105; $x++){
	//$counter++;
	if(strlen($counter) < 2){$counter = "0" . $counter;}
	$indata = fgets($myfile);
	$position = strpos($indata,","); 
	$substring = substr($indata, $position + 1);
//	echo "ExtendedMacroPortLimit " . $x . " $substring\r";
	$query = "update config set cdata = '$substring' where command = '*4005' and sub = $x";
//	$result=safe_query($query);
	}
	
//DST Start Date - 4042-4045	
	$substring ="";	
	for($b = 1; $b <= 4; $b++){			
		$indata = fgets($myfile);		
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));		
		if($b < 4){$substring = $substring . $sub;}		
	}		
//	echo "DST Start Date " . " $substring\r\n";	
	$query = "update config set cdata = '$substring' where command = '*2131' and sub = 1";
	$result=safe_query($query);


//DST End Date - 4046-4049	
	$substring ="";	
	for($b = 1; $b <= 4; $b++){			
		$indata = fgets($myfile);	
		$position = strpos($indata,","); 
		$sub = chr(intval(substr($indata, $position + 1)));		
	//	echo "$sub\r\n";
		if($b < 4){$substring = $substring . $sub;}		
	} 	
	//echo "DST End Date " . " $substring\r\n";
	$query = "update config set cdata = '$substring' where command = '*2131' and sub = 0";
	$result=safe_query($query);
	
//DST Start Hour 1 or 2 AM - 4050
$indata = fgets($myfile);
//echo "$indata\r\n";
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DST Hour Select " . " $substring\r\n";
$query = "update config set cdata = $substring where command = '*2132' and sub = 1";
$result=safe_query($query);	

//Debug print on/off - 4051****We don't document this feature so just suck up byte
$indata = fgets($myfile);
//echo "$indata\r\n";
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "Debug Print " . " $substring\r\n";

//VoiceResponse on/off - 4052
$indata = fgets($myfile);
//echo "$indata\r\n";
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "Debug Print " . " $substring\r\n";
$query = "update config set cdata = $substring where command = '*2135'";
$result=safe_query($query);	

//DST End Hour 1 or 2 AM - 4053
$indata = fgets($myfile);
//echo "$indata\r\n";
$position = strpos($indata,","); 
$substring = substr($indata, $position + 1);
//echo "DST Hour Select " . " $substring\r\n";
$query = "update config set cdata = $substring where command = '*2132' and sub = 0";
$result=safe_query($query);


//Clock Delay - 4054 *****NOT USED AT THE MOMENT SO SUCK UP BYTE****
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$buffer1 = intval(substr($indata, $position + 1));
$indata = fgets($myfile);	
$position = strpos($indata,","); 
$buffer2 = intval(substr($indata, $position + 1));
$substring = $buffer1 + $buffer2 * 256;
//echo "Clock Delay ". " $substring\r\n";


//use up currently unused memory in 210
for ($x = 1; $x <= 45; $x++) {
  $indata = fgets($myfile);  
} 
	
//'*suck up "EEPROM DONE" line  
$indata = fgets($myfile); 
echo "END OF MEMORY " . "$indata\r\n";


 
//Now for External EEPROM if installed


//Extended Macros 1 - 390 (91 - 105)
//$itemp ="";
for($x = 91; $x <= 105; $x++){	
	$substring ="";	
	for($b = 0; $b <= 20; $b++){		
		$indata = trim(fgets($myfile));
//	if($x=="95"){echo "InDATA " . $x .  " $indata\r\n";}

		$position = strpos($indata,","); 
		$iload[$b] = substr($indata, $position + 1);
	}		
	$itemp = 0;
	$a = 0;
	$substring ="";
	do{		
//	if($x=="95"){	echo "iload[" . $a . "] " .  "$iload[$a]\r\n";}//
		
		if($iload[$a] != 0){
			$itemp = $iload[$a];
			$a++;
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}
		if($iload[$a - 1] == 255){
			$itemp = $itemp + $iload[$a];
			$a++;
		}		
		}else{
			break;
		}	
		$substring = $substring . " " . $itemp; 
	
	}while($a <= 20);		

	$macronum = $x;
	if($substring ==""){$substring = "NONE STORED";}

//	echo "Macro "  . $macronum . " $substring\r\n";	

	$query = "update config set cdata = '$substring' where command = '*4002' and sub = $macronum";
	$result=safe_query($query);		

}






fclose($myfile);
exit();
 
}
?>

