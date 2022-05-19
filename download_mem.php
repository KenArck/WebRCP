
<?php

include("progress.class.php");

$tasks = 4096; // total tasks to run

$progress = new Progress("Downloading", $tasks);



$port = "/dev/ttyUSB0";
$cmd = "1SendEram";
$eRam = "";
$memfile = fopen("download.mem", "w\n");

$c = exec('stty -F '.$port.' cs8 -parenb -cstopb -echo raw speed 19200');

if(!file_exists($port)) {
	echo "Device doesn't exist.";
	die();
} else {
	$f = fopen($port, "w+");
	fwrite($f, $cmd."\r");
	sleep(0.1);
	$indata="";
	$timediff =0;
	$starttime = date('s');
	$substring = "";

	while(substr($indata,0,1) != "C"){	//look for starting C of Complete
$progress->increase();
		
		$indata = fgets($f);		
	
		if($indata != ""){
		//	echo "INDATA " . "$indata\r";	
			fwrite($memfile, $indata);	#write to download.mem
			fwrite($f,"OK\r");	
			$starttime = time(); //reset timer		
		}
		
		if($indata == "TimeOut"){die("Timeout from controller");}		
		if(substr($indata,0,1) == "C"){
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
$progress->end();
?>