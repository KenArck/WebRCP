<?php
		
include("global.php");

$x = Null;

	$senddata = "";
	sendserial($senddata); #clear out buffer
	sleep(0.1);
	$senddata = "1*5100" . date("His") . "\r";		
	writeserial($senddata);
	$x = readserial();	
	print "$x\r";
		
	sleep(1);
	$senddata = "1*5101" . date("mdy") . "\r";
	writeserial($senddata);
	$x = readserial();		
	print "$x\r";
		
	
?>
