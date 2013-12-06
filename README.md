What is it?
This is a script to chat in colorful fonts in Nexuiz/Rocketminsta. 
Mechanism:
Due to the limitations of quakec scripts an external program is called. The script uses curl to call an external web server or 
nal server or a localhost server. The server prints a scrip to set speak variable. Curl downloads the output script into ...data/dlcache folder. 
To speak the script is just executed using exec function.

Setup:
1. Setting up Nexuiz script:
Create autoexec.cfg in Nexuiz/data under windows or $HOME/.Nexuiz/data under linux. Place color_text.cfg in some folder and call it from 
autoexec.cfg using the command exec /folder path/color_text.cfg. Or simply copy paste the code under color_text.cfg into autoexec.cfg.
2. Setting up webserver:
Download and install xampp.
Place speak.pl in xampp/cgi-bin/ folder. In speak.pl edit and complete the line #!"--SomePath--\xampp\perl\bin\perl.exe" with your own path. Start xampp.

Usage:
1.press L to type; then press K to upload /download; press O to say OR press P to team_say
2. If you want to chat in console, type chat1 in console, then press K and then press O to say to all OR press P to team say
Important: Clear *.chat files from dlcache folder after or before running nexuiz

Caution:
i) give some time to download after u press K - some milliseconds
ii) There are some obvious limitations since an web address is used as an input chat. For instance "+" cannot be typed instead would have to use %2B for that symbol.
An easier way to do is to store %2B in some variable say _plus and whenever u want to type a+b type a$_plusb.

