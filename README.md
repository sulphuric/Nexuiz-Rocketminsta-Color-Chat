What is it?
This is a script to chat in colorful fonts in Nexuiz/Rocketminsta.

Mechanism:
Due to the limitations of quakec scripts an external program is called. The script uses curl to call an external web server 
or a localhost server. The server prints a script to assign speak variable. Curl downloads the output script into ...data/dlcache folder. 
Finally, to render, the script is just executed using exec function.

Setup:
1. Setting up the Nexuiz script:
Create autoexec.cfg in Nexuiz/data under windows or $HOME/.Nexuiz/data under linux. Place color_text.cfg in a folder and call it from 
autoexec.cfg using the command exec /~folder path/color_text.cfg. Or simply copy paste the code under color_text.cfg into autoexec.cfg.
2. Setting up the Webserver:
Download and install xampp server (portable is good enough) or any other server that supports php.
Then, place speak.php in your server directory usually in htdocs folder under Xampp. 
Usage:
1. Press O to input chat for public OR press P to input chat for team. Then press K to print chat.
2. If you want input chat in console, use say1 command followed by your text for public chat or say2 command followed by your text for team chat .

Important: 
Clear *.chat files from dlcache folder before running nexuiz. One good way is to run nexuiz with a batch script which clears the chat files
and calls nexuiz client. E.g in windows create a nexuiz.bat file inside nexuiz folder and add the following two lines to the file:

del data/dlcache/*.chat
nexuiz.exe

Then every time you want to run nexuiz just run nexuiz.bat file.
Caution:
i) There are some obvious limitations since an web address is used as an input chat. For instance the input "+" is lost during the web transaction, 
instead %2B should be used.


