<?php
function convertBack($packedstring){
		$lowconv ="";
		$highconv="";
		$newstring = ord($packedstring);
		$low = ($newstring & 0x0F);
		$high = ($newstring & 0xF0) >> 4;		
		if($low == "1"){$lowconv = "1";}
		if($low == "2"){$lowconv = "2";}
		if($low == "3"){$lowconv = "3";}
		if($low == "4"){$lowconv = "4";}
		if($low == "5"){$lowconv = "5";}
		if($low == "6"){$lowconv = "6";}
		if($low == "7"){$lowconv = "7";}
		if($low == "8"){$lowconv = "8";}
		if($low == "9"){$lowconv = "9";}
		if($low == "10"){$lowconv = "0";}
		if($low == "11"){$lowconv = "*";}
		if($low == "12"){$lowconv = "#";}
		if($low == "13"){$lowconv = "A";}
		if($low == "14"){$lowconv = "B";}
		if($low == "15"){$lowconv = "C";}
	
		if($high == "1"){$highconv = "1";}
		if($high == "2"){$highconv = "2";}
		if($high == "3"){$highconv = "3";}
		if($high == "4"){$highconv = "4";}
		if($high == "5"){$highconv = "5";}
		if($high == "6"){$highconv = "6";}
		if($high == "7"){$highconv = "7";}
		if($high == "8"){$highconv = "8";}
		if($high == "9"){$highconv = "9";}
		if($high == "10"){$highconv = "0";}
		if($high == "11"){$highconv = "*";}
		if($high == "12"){$highconv = "#";}
		if($high == "13"){$highconv = "A";}
		if($high == "14"){$highconv = "B";}
		if($high == "15"){$highconv = "C";}			
		$recoveredstring = $lowconv . $highconv;
		return $recoveredstring;	
	}
	?>