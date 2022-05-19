
<SCRIPT LANGUAGE=JavaScript>
<!--
function myFunction() { 
  var nwin = window.open("preloader.php","functpopup","width=320,height=300, top= 300, left = 700, resizable=yes,scrollbars=yes");
  if((!nwin.opener) && (document.windows != null))
    nwin.opener = document.windows;	
}
</script>


<?php
include("global.php");
include("header.php");

$target_dir = "uploads/";
$target_file = "uploads/" . basename($_FILES['fileToUpload']["name"]);


//set upload flag as good (will be set "bad" later if file type is wrong)
$uploadOk = 1;

//get the file extension for later processing
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);


if(isset($_POST['upload'])){
//this calls the python script to upload bin file to controller	
header("Location: webupdater.html");
exit();

}

if(isset($_POST['cancel'])){
	header("Location: firmware.php");
	exit();
}

/*
 
$pid = popen( $command,"r");

 
echo "<body><pre>";
while(!feof( $pid)){
 echo fread($pid, 256);
 flush();
 ob_flush();
// echo "<script>window.scrollTo(0,99999);</script>";
 //usleep(100000);
}
pclose($pid);


*/

// Check if file already exists
//if (file_exists($target_file)) {
//	print"
//	  <H3><CENTER>Sorry, file already exists. Please use the BACK button of your browser to select a different file</H3></CENTER>
//	  ";	
 //   $uploadOk = 0;
//}

// Allow certain file formats - must be either a hex or bin extension filename and nothing else
if($FileType == "") {    
	print"
	  <H3><CENTER>Sorry, nothing found. Please use the BACK button of your browser to select a different file</H3></CENTER>
	  ";	
    $uploadOk = 0;
  exit();
}

if($FileType != "bin"){    
	print"
	  <H3><CENTER>Sorry, you can only upload hex or bin files. Please use the BACK button of your browser to select a different file</H3></CENTER>
	  ";	
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
 //   echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 //  print "<BR><BR><BR>file " . $target_file;
       $myfile = fopen("uploads/upload", "w+") or die("<CENTER><H2><BR><BR><BR>Unable to open file!</CENTER></H2>"); 	 
	   fwrite($myfile, $target_file);	   
	   fclose($myfile);
	   
	   
	   if($uploadOk <> '0'){print"	<br></br><br></br>	
				 <form name=\"preupload\" method=\"post\">
				 <table align=\"center\" border=1 cellspacing=0 cellpadding=4 width=\"620\">
	<tr><TD class=\"titlebar\"><B>Send To RC210</B></TD></tr>
	<tr>
		<td class=\"dialog\">		
			<table class=\"dialog\" align=\"center\" border=0 cellspacing=0 cellpadding=4 width=\"100%\">	
				<tr>
					<td colspan=2>
							
						<H3><CENTER>Your firmware file has been successfully uploaded to the server</H3></CENTER>
						
						<CENTER><button type=\"button\" onclick=\"myFunction()\">Send To RC210</button></CENTER>
							<input type=\"submit\" value=\"Cancel\" name=\"cancel\" >
						</CENTER>	
							</form></CENTER>
									
											
					</td>
				</tr>	
			</table>			
		</td>
	</tr>
</table>
</center>

";
}
				

    } else {
        print"
				 <H3><CENTER>Sorry, there was an error uploading your file. Please use the BACK button of your browser to try again</H3></CENTER>
				";
    }

}



include("footer.php");

?>