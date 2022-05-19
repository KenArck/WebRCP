<?php

$port = "/dev/ttyUSB0";
$cmd = "1SendRTCEram";
$eRam = "";
$memfile = fopen("downloadrtc.mem", "w\n");

$c = exec('stty -F '.$port.' cs8 -parenb -cstopb -echo raw speed 19200');

if(!file_exists($port)) {
	echo "Device doesn't exist.";
	die();
} else {

	$f = fopen($port, "w+");
	fwrite($f, $cmd."\r");

sleep(0.5);
$indata="";
$timediff =0;
$starttime = date('s');
$substring = "";
$v = 1;

while ($v == 1){	
	$indata = fgets($f);	
		
	if($indata != ""){
		echo "INDATA " . "$indata\r";	
		fwrite($memfile, $indata);	#write to download.mem
		fwrite($f,"r\r\n");	
		$starttime = time(); //reset timer		
	}		
	
		
	if($indata == "TimeOut"){die("Timeout from controller");}	
	
	if($indata == "T3Complete"){
		fclose($memfile);
		$indata = fgets($f); //read final +SENDE and clear from buffer
		exit();
	}	

	$substring = substr($indata,0,1);		
	if($substring =="-"){    		
		print "We encountered an error when receiving $indata". "Please close window and try again\r\n";	
		fclose($memfile);
		exit();		
	}
	
	$endtime = date('s');		
	$timediff = $endtime - $starttime;
	
	if($timediff > '4'){
		print"Serial Timeout! There was no response from the RC210. Please close this window, check your serial connections and try again\r\n";			
		fclose($memfile);
		exit();
	}
	$indata ="";

}//while
}

?>