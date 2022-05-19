<?php
include("global.php");

$myfile = fopen("downloadrtc.mem", "r") or die("<BR><BR><BR><H2>Unable to open file!</H2>");

while(!feof($myfile)) {	
	
//Remote Base memories	
	$indata = trim(fgets($myfile));	 
	if(substr($indata,0,2) == "T1"){ 
//		echo "$indata\r\n";
		$memory = (intval(substr($indata,2,2) + 10));		
		$freq = (substr($indata,4,3)) . "." . (substr($indata,7,3));
		$offset = substr($indata,10,1);
		$ctcss= substr($indata,11,2);
		$ctcssmode= substr($indata,13,1);	
		$radiomode= substr($indata,14,1);
	
		$query = "update remote set freq = '$freq' where memory = $memory";
		$result=safe_query($query);
		$query = "update remote set offset= '$offset' where memory = $memory";
		$result=safe_query($query);
		$query = "update remote set ctcss = '$ctcss' where memory = $memory";
		$result=safe_query($query);
		$query = "update remote set ctcssmode = '$ctcssmode' where memory = $memory";
		$result=safe_query($query);
		$query = "update remote set opmode = '$radiomode' where memory = $memory";
		$result=safe_query($query);		
	}//T1	

	$x = 0;
	//Message Macros
	
	if(substr($indata,0,2) == "T2"){ 	
		$phrasenum = (intval(substr($indata,2,2) + 40));
		$length = intval(substr($indata,-1));
		$indata = substr($indata,5);
		$iload = explode("*",$indata);
	
		$a = 0;
		$substring ="";
		for($a = 0; $a < $length ; $a++){
		if (trim(strlen($iload[$a]) < 2)){$iload[$a]= "00" . $iload[$a];}
		if (trim(strlen($iload[$a]) < 3)){$iload[$a]= "0" . $iload[$a];}
		$itemp = trim($iload[$a]);	
		$substring = $substring . " " . $itemp; }
	//	echo "Memory# " . $memory . " " . "$substring\r\n";
	
		$query = "update config set cdata = '$substring' where command = '*2103' and sub = $phrasenum";
		$result=safe_query($query);	
	}//T2


	//DTMF memories
	
	if(substr($indata,0,2) == "T3"){ 
		$substring ="";
	//	echo "$indata\r\n";
		$dtmfmem = (intval(substr($indata,2,2) + 20));	
		$indata = substr($indata,4);

		if($indata != "mplete"){	
			$length = trim(strlen($indata));	
			
			for($x = 0; $x < $length; $x++){				
				$sub = substr($indata,$x,1);	
				$substring = $substring . $sub . " ";			
			}
			
			$query = "update config set cdata = '$substring' where command = '*2105' and sub = $dtmfmem";
			$result=safe_query($query);	
		}
	}//T3
	
}//while(!feof($myfile))

fclose($myfile);

?>