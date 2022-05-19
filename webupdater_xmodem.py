#!/usr/bin/python

#This is the XMODEM version for the 2561 bootloader

#import logging
#logging.basicConfig()

from sys import argv

import serial, time, sys, fileinput, os




from xmodem import XMODEM

#read in file to be uploaded data
file = open("/var/www/html/WebRCP/uploads/upload")
filename =file.read()

#os.remove("/var/www/html/WebRCP/uploads/upload")
file.close()


#open and configure serial port
ser = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=19200,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS  
)

#clear out any crap in buffer
ser.write("\n\r".encode())
ser.write("\n\r".encode())
ser.write("\n\r".encode())
time.sleep(.5)

print ("Resetting RC210 and waiting for Bootloader Active Character......")

#send reset command to 210
reset = "1*219999\r"
ser.write(reset.encode())

time.sleep(.5)

#change baudrate to 57600 and reconfigure serial port
ser = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=57600,
    parity=serial.PARITY_NONE,
	xonxoff=0, 
	rtscts=0,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout=1
)

#wait for % and then move on
indata = ""
Counter = 0
while indata != "%":  
  indata = ser.read()
  print( indata)
  Counter = Counter + 1
  if Counter > 10:
   sys.exit("Timed out waiting for Bootloader Active Character. Please close window and try again")

print ("Received Bootloader Active Character. Starting File Send\n")
ser.write("{".encode())

#defines for xmodem module
def getc(size, timeout=1):
	return ser.read(size) or None

def putc(data, timeout=1):
    return ser.write(data)  # note that this ignores the timeout
modem = XMODEM(getc, putc)

#start actual xmodemCRC transfer
stream = open(filename,'rb')
modem.send(stream)

print ("\n") 
print ("Firmware successfully uploaded") 

ser.close()




