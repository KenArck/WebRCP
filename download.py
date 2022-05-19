#!/usr/bin/python3

import serial, time, sys, fileinput
 
#open and configure serial port
ser = serial.Serial(  
	port='/dev/ttyUSB0',
    baudrate=57600,
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
file = open("download.mem", "w")

#send command to rc210 to start download
ser.write("1SendEram\r\n".encode())

indata ="" 
Counter = 0
progresscounter = 0
var = 1

while var==1:
  indata = ser.readline()
  indata = indata.decode("utf-8")
  indata = indata.strip()
  print (indata)  

 #check for first character of "Complete" and exit loop
  if indata[0] == "C":
    break
  
  if(len(indata) == 0 or indata[1] =="-" or indata[1] == "+" or indata[1] =="T"):
    Counter = 1 #Counter + 1	
  else:
    Counter = 0 
    ser.write("\r".encode())	
    serdata = str(indata)+"\r\n"
    file.write(serdata)
    progresscounter += 1
    progress = progresscounter / 41
    ser.write("OK\r\n".encode())
	
 #   print ('\rDownloading: %s (%d%%)' % ("|"*(progress/2), progress),
 #   sys.stdout.flush()
 
  
  if Counter > 5:
    f.close()
    sys.exit("RC210 did not respond. Exiting")
	
print ("\nDownload Successful")
  
  
file.close()
sys.exit()


