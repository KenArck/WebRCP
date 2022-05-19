#!/usr/bin/python

import serial, time, sys, fileinput
 
#open and configure serial port
ser = serial.Serial(
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
 ser.write("\r".encode())

 time.sleep(.1)
 

#open file for download
file = open("download.mem", "w+")

#send command to rc210 to start download
ser.write("1SendEram\r\n".encode())

indata ="" 
Counter = 0
progresscounter = 0
var = 1

while var == 1:
  inser = str(ser.readline())
  indata = inser.strip
  print (indata)
  if indata == "Complete": #check for first character of "Complete" and exit loop
    break

    Counter = Counter + 1	
  else:
    Counter = 0 
    ser.write("\r".encode())
    file.write(indata)
    #LineCount -= 1 
    progresscounter += 1
    progress = progresscounter / 44
    if( progress > 100 ) : progress = 100
    ser.write("OK\r\n".encode())
	
	
    #print( '\rDownloading: %s (%d%%)' % ("|"*(progress/2), progress)),
    sys.stdout.flush()
 

  
  if Counter > 10 :
    file.close()
    sys.exit("RC210 did not respond. Exiting")

	
print ("\nDownload Complete")
  
  
file.close()

#now for RTC


sys.exit()


