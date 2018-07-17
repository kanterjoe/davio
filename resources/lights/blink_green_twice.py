#!/usr/bin/python

# Simple strand test for Adafruit Dot Star RGB LED strip.
# This is a basic diagnostic tool, NOT a graphics demo...helps confirm
# correct wiring and tests each pixel's ability to display red, green
# and blue and to forward data down the line.  By limiting the number
# and color of LEDs, it's reasonably safe to power a couple meters off
# USB.  DON'T try that with other code!

import time
from dotstar import Adafruit_DotStar
from pprint import pprint
import sys
sys.path.append('/home/pi/Desktop/daveio/install/dotstar/')
numpixels = 60 # Number of LEDs in strip

# Here's how to control the strip from any two GPIO pins:
datapin   = 10
clockpin  = 24
# datapin   = 19
# clockpin  = 23
# strip     = Adafruit_DotStar(numpixels, datapin, clockpin)
strip     = Adafruit_DotStar(numpixels)

# Alternate ways of declaring strip:
# strip   = Adafruit_DotStar(numpixels)           # Use SPI (pins 10=MOSI, 11=SCLK)
# strip   = Adafruit_DotStar(numpixels, 32000000) # SPI @ ~32 MHz
# strip   = Adafruit_DotStar()                    # SPI, No pixel buffer
# strip   = Adafruit_DotStar(32000000)            # 32 MHz SPI, no pixel buf
# See image-pov.py for explanation of no-pixel-buffer use.
# Append "order='gbr'" to declaration for proper colors w/older DotStar strips)

strip.begin()           # Initialize pins for output
strip.setBrightness(64) # Limit brightness to ~1/4 duty cycle

# Runs 10 LEDs at a time along strip, cycling through red, green and blue.
# This requires about 200 mA for all the 'on' pixels + 1 mA per 'off' pixel.
def hex_to_rgb(value):
    value = value.lstrip('#')
    lv = len(value)
    return tuple(int(value[i:i + lv // 3], 16) for i in range(0, lv, lv // 3))


def rgb_to_hex(rgb):
    return '0x%02x%02x%02x' % rgb

redpos = 0
grepos = 44
blupos = 60

reddir = 1
gredir = 1
bludir = -1

red = 0x00FF00        # 'On' color (starts red)
gre = 0xFF0000
blu = 0x0000FF
white = 0xFFFFFF



for iteration in range(0, 4):                    # Loop 256 times

    if (iteration % 2 == 0):
        for i in range(0,numpixels):
            strip.setPixelColor(i, gre)
    else:
        for i in range(0,numpixels):
            strip.setPixelColor(i, 0)
    strip.show()                     # Refresh strip


    time.sleep(1.0 / 5)
