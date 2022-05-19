<?php

//open file to upload
$binfile = fopen("/var/www/html/WebRCP/uploads/upload","r") or die("Unable to open file");
$filetoload = fgets($binfile);
$file = fopen($filetoload,"rb") or die("Unable to open file");

 
//define xmodem constants
const  SOH = 0x01;
const  NAK = 0x15;
const  ACK = 0x06;
const  CAN = 0x18;
const  EOT = 0x04;

#Set serial port parameters	
$comport = "/dev/ttyUSB0";	

$c = exec('stty -F '.$comport .' -parity hupcl -igncr -crtscts -cstopb -ixon clocal -echo raw 19200');
$f = fopen($comport, "w+");
stream_set_blocking($f, false);
stream_set_timeout($f, 4000);


//reset controller

fwrite($f,"11111\r");
usleep(100000);
$data = "1*2199999\r";
//fwrite($f,$data);
fwrite($f,$data);

$read="";
sleep(3.0);

#close and repen comport at bootloader baud rate
fclose($f);
$c = exec('stty -F '.$comport.' -parity hupcl -igncr -crtscts -cstopb -ixon clocal -echo raw 57600');
$f = fopen($comport, "w+");
stream_set_blocking($f, false);
stream_set_timeout($f, 4000);

$retries = 4000;

echo "Starting....";

TESTFORSTART:

//echo "TestForStart\r\n";

//wait for % from controller
$read = readserial();

//usleep(1000);

if($read != ""){echo "READ " . "$read\r\n";}

if($read == "%"){
	echo "We received a start from the controller\r\n";
	fwrite($f,"{");
	Goto PORTLOADER;
} else {
	$retries--;	
	if($retries <> 0){Goto TESTFORSTART;}
}
die("Timeout!\r\n");	




PORTLOADER:
$in="";
//exit();

//wait for NAK from controller then start upload
While ($in == "" ){
	$in = readserial();	
//	echo "IN " . "$in\r\n";	
}
$data = ord($in);
if($data == NAK){
echo "We received a NAK so start upload\r\n";
} else {
//echo "IN " . "$data\r\n";

die("No NAK received!\r\n");
}


$csum = 0;
$block = 0;
$resend = 0;
$bretries = 5;
$count =0;
$read = "";
$data= "";

SENDPACKET:
	fwrite($f,Chr(SOH));

 if($resend == 0){$block++;}
 
 $block2 = 0xFF - $block;
 fwrite($f,Chr($block));   //send Block #
 fwrite($f,Chr($block2)); 
  
while(!feof($file)){
	$loopcounter = 1;
	//echo "Before " . "$loopcounter\r\n";
	for($x = 1; $x <= 128; $x++){
		if($resend == 0){
			$buf[$x] = ord(fread($file,"1"));
			//echo $buf[$x];
			if($loopcounter < 128){$loopcounter++;}
			if(feof($file)){break;}
		 }
	}
	fseek($file,1,SEEK_CUR);
	
	If($loopcounter = 128){
		for($x = 1; $x <= 128; $x++){ 
		  $csum = $csum + $buf[$x];
		  if($csum > 255){$csum = $csum - 256;}	//always 255 or less
		 fwrite($f,Chr($buf[$x]));     
		}
	} else { //loopcounter is < 128
		for($x = 1; $x <= $loopcounter; $x++){        
          fwrite($f,Chr($buf[$x]));
          $csum = $csum + $buf[$x]; //get checksum by adding all 128 bytes together
		  if($csum > 255){$csum = $csum - 256;}	//always 255 or less
		}	       
		for($x = ($loopcounter + 1); $x <= 128; $x++){				
          $buf[$x] = 26 ;      
          $csum = $csum + $buf[$x];
		if($csum > 255){$csum = $csum - 256;}	//always 255 or less
		 fwrite($f,Chr(26)); //pad	
          $transferdone = 1;         
		}
	} //If($loopcounter = 128)
		
	fwrite($f, Chr($csum));
	
		echo "loopcounter " . "$loopcounter\r\n";
		echo "CSUM " . "$csum\r\n"; 
	
	
	While ($read == "" ){
		$read = readserial();	
		usleep(1000);
	}
	
	$read = ord($read);
	sleep(1.0);
	
	echo "We sent block, response is " . "$read\r\n";
	echo "Resend is " . "$resend\r\n";
	echo "Bretries is " . "$bretries\r\n";
	If($read == ACK){
      print "Data Good\r\n";
      $resend = 0;
      $bretries = 5 ;     
    }
	
    If($read == NAK){
      Print "Data Bad\r\n";
      Print "Calculated Csum " . "$csum\r\n";
      $resend = 1;
	}

	if($read == CAN){Print "Transfer Cancelled\r\n";
	}
	
	$csum = 0;
	$bretries--;
//	die("END");

	if($bretries > 0){
		if($tranferdone = 1){
			Do {
				$count++;
				While ($read == "" ){
					$read = readserial();
				}
				If ($read != 0){
					break;
				}else{
					fwrite($f,Chr(EOT));         
				}
			} while ($count < 6);
			Goto SENDPACKET;
		} //if($tranferdone = 1)
	}else{ //$bretries

		Print "Transfer Cancelled\r\n";
		fwrite($f,Chr(EOT)); 
	}//if($bretries >0		
	
} //(! feof($file))

fclose($binfile);







function writeserial($f,$cmd){
	global $f;
	global $myfile;
	global $comport;
	$newstring = "";

//	echo "Sent " . "$cmd\r\n";
	if(!file_exists($comport)) {
		echo "[Error] Serial port not valid. Check devices!\n";
		die();
	} else {		
		fwrite($f, $cmd);
	}	
}

function readserial(){	
	global $f;
	
	$LoopCounter = 1;		
		while(1) {
			usleep(90000);
			$dataOut = fgets($f);			
		//	$newstring = "Received " . $dataOut;
			//	echo $newstring;			
				break;	
			if($LoopCounter > 20) { echo "[Error] Check Serial Connection!\n"; die(); break; }
		$LoopCounter++;
		}
	return $dataOut;
}













?>