<?php

//error_reporting(E_ERROR|E_WARNING);

error_reporting(E_ALL);

#Set serial port parameters	
$comport = "/dev/ttyUSB0";	
$c = exec('stty -F '.$comport.' -parity hupcl -igncr -crtscts -cstopb -ixon clocal -echo raw 19200');
$f = fopen($comport, "w+");
stream_set_blocking($f, false);
stream_set_timeout($f, 4000);

#for temp troubleshooting
//$myfile = fopen("commands_sent.txt", "w\n");
  
 //edit the following line for your time zone
 date_default_timezone_set("America/Los_Angeles");


function writeserial($cmd){
	global $f;
	global $myfile;
	global $comport;
	$newstring = "";

#for temp troubleshooting
//	if(substr($cmd,1,5)!='*4005'){return;}
//	if(substr($cmd,1,5)!='*4001' && substr($cmd,1,5)!='*4002' && substr($cmd,1,5)!='*4003' && substr($cmd,1,5)!='*4005'){return;}
//	echo "CommandSent " . "$cmd\r\n";
	
	if(!file_exists($comport)) {
		echo "[Error] Serial port not valid. Check devices!\n";
		die();
	} else {		
		fwrite($f, $cmd);
		
#for temp troubleshooting
//	$newstring = "CommandSent " . $cmd;
//	fwrite($myfile, $newstring . "\r\n");	
	}	
//	usleep(250000);
}

function readserial($cmd){	
	global $f;
	//global $myfile;
	
	$LoopCounter = 1;		
		while(1) {
			usleep(90000);
			$dataOut = fgets($f);			
			$newstring = "Received " . $dataOut;
			echo $newstring;
		#for temp troubleshooting
		//	fwrite($myfile, $newstring . "\r\n\r\n");				
			if(strlen($dataOut) > 5) {	
				break;
			} else {
				fwrite($f, $cmd);
			}
			if($LoopCounter > 10) { echo "[Error] Check Serial Connection!\n"; die(); break; }
		$LoopCounter++;
		}
	return $dataOut;
}

function clearflags(){
	
	//flag vars database entry as being sent			
$query = "update vars set changed = 0";
$result=safe_query($query);

//flag commands database entry as being sent		
$query = "update commands set changed = 0";
$result=safe_query($query);


//flag config database entry as being sent
$query = "update config set changed = 0";
$result=safe_query($query);


//flag config database entry as being sent
$query = "update remote set changed = 0";
$result=safe_query($query);

}




 
$host = 'localhost';
$user = 'rc210';
$pass = 'rc210';
$db   = 'rc210';
$charset = 'utf8';

// This part sets up the connection to the
// database (so you do not need to reopen the connection again on the same page).
$con= new mysqli($host,$user,$pass,$db);

// check connection 
if ($con->connect_errno) {	
    printf("Connect failed: %s\n", $con->connect_error);
    exit();
}

//**************EVERYTHING ABOVE IS OK IN PHP 7

// This function will execute an SQL query against the currently open
// MySQL database. If the global variable $query_debug is not empty,
// the query will be printed out before execution. If the execution fails,
// the query and any error message from MySQL will be printed out, and

function safe_query ($query = "")
{
	global $con;
	global	$query_debug;
		
	if (empty($query)) { return FALSE; }

	if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }	
	
	$result = $con->query($query)	
	
		or die("ack! query failed: "
			."<li>errorno=". $con->errno
			."<li>error=". $con->error
			."<li>query=". $query
		);
	return $result;
}

// This function will provide a special input based on what is passed

function DynamicInput ($inputspec = "", $altspec="", $fieldname="", $currentval="",$size=35, $maxlen="")
{
	if( strpos($inputspec,";") == 0){
		print "<INPUT type=\"text\" name=\"$fieldname\" value=\"$currentval\" size=\"$size\" maxlength=\"$maxlen\">";
	} else {
		$invals=array();
		$inalt=array();
		$invals=explode(";",$inputspec);
		if($altspec==""){
			$inalt=$invals;
		} else {
			$inalt=explode(";",$altspec);
		}
		$listlength=count($invals);
		print "<SELECT name=\"$fieldname\">\n";
		for($i=0 ; $i<$listlength ; $i++){
			print "<OPTION value=\"$invals[$i]\" ";
			if($currentval==$invals[$i]){
				print "SELECTED";
			}
			print ">$inalt[$i]\n";
		}
		print "</SELECT>\n";
	}
}
