#!/usr/bin/python

import serial, time, sys, fileinput
 
#open and configure serial port
ser = serial.Serial(
   # port='/dev/ttyAMA0',
	port='/dev/ttyUSB0',
    baudrate=19200,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout = .1	
)

#first, clear out 210 buffer
count = 0
while (count < 3):
 count +=1  
 ser.write("\r") 
 time.sleep(.1)
 

#open file for download
file = open("downloadrtc.mem", "w+")


#send command to rc210 to start download
ser.write("1SendRTCEram\r\n")

indata ="" 
Counter = 0
progresscounter = 0
var = 1

while var==1:
  indata = ser.readline()
  indata = indata.strip()
#  print indata  
  
  
  print "INDATA: ", indata
  if (indata=="T3Complete"): 
    file.write(indata)
    break
  
  if(indata[0:2] =="-R"):	
     Counter = Counter + 1
 #    break	
	 
  if(indata !=""):
    Counter = 0
  indata = indata + "\r\n"
  if(indata[0] =="T"): file.write(indata)
  time.sleep(.1)
  ser.write("r\r\n")  
  sys.stdout.flush() 
  
  if Counter > 10:
    file.close()
    sys.exit("RC210 did not respond. Exiting")
	
print "\nDownload Complete"
 
file.close()
sys.exit()


