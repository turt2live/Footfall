# INSTALL RASPBIAN "JESSIE"
###CONFIGURE THE RASPBERRY PI.
1.	Select 1 Expand Filesystem and hit Enter.
2.	Select Enable Camera and hit Enter.
3.	Select 8 Advanced Options and hit Enter.
4.	Select A3 Memory Split and hit Enter.
  1. Type 64 and Hit <ok>.

5.	Select 3 Boot Options
6.	Select B1 Console or B2 Console Autologin
7.	Reboot when prompted or type sudo reboot
8.	Update everything to the latest version.
  1. sudo apt-get clean
  2. sudo apt-get update
  3. sudo apt-get upgrade

Note: The above steps may take a little while.
Installing openFrameworks on the Raspberry Pi.
###DOWNLOAD OPENFRAMEWORKS.

1.	wget http://openframeworks.cc/versions/v0.9.3/of_v0.9.3_linuxarmv6l_release.tar.gz
2.	mkdir openFrameworks
3.	tar vxfz of_v0.9.3_linuxarmv6l_release.tar.gz -C openFrameworks --strip-components 1

###INSTALL PACKAGES AND COMPILE OPENFRAMEWORKS:

1.	cd /home/pi/openFrameworks/scripts/linux/Debian
2.	sudo chmod +x install_dependencies.sh
3.	sudo ./install_dependencies.sh
4.	make Release -C /home/pi/openFrameworks/libs/openFrameworksCompiled/project

#Installing Footfall on the Raspberry Pi
###DEPENDENCIES FOR APP.
1.	cd /home/pi
2.	git clone https://github.com/WatershedArts/Footfall.git
3.	cp /home/pi/Footfall/getrepos.sh /home/pi/openFrameworks/addons/getrepos.sh
4.	cd /home/pi/openFrameworks/addons
5.	sudo chmod +x getrepos.sh
6.	./getrepos.sh
7.	cd /home/pi/openFrameworks/addons/ofxCvPiCam
8.	mv libs old-libs

###BUILD FOOTFALL APP
1.	cp /home/pi/Footfall/ThreadedFootfall/ /home/pi/openFrameworks/apps/myApps/projectFolder/ -r
2.	Move the Application directory from the Repo into openFrameworks/apps/myApps/
3.	Create a new app your openFrameworks apps/myApps directory then copy the source code across, including the addons.make file.
4.	cd projectFolder
5.	sudo make clean
6.	sudo make

If you are using a mouse and keyboard.
You can either launch the app by
* ```make run```
or
* ```bin/projectName```

However, if you are sshing into the pi.
Launch the app like so.

* ```DISPLAY=:0 make run & disown```
or
* ```DISPLAY=:0 bin/projectName & disown```
This puts the app in the background.
