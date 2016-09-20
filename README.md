TV viewport resolution: 962 x 453

how to run it:

Start transaction reader:
```sh
$ php desktopQueue/bin/readTransactions.php
```
and everything should work.


Add songs as batch via command line:
```sh
$ php adminAndMobile/bin/add-songs.php <directory>
```

If the google chrome browser on android does not automatically play songs, please, read this:
http://stackoverflow.com/questions/12587977/html5-audio-chrome-on-android-doesnt-automatically-play-song-vs-chrome-on-pc-d

If the connection to mysql server goes away (General error: 2006 MySQL server has gone away), setup the php configuration like this: mysqli.reconnect = On

To make readTransaction.php script run permanently, create file `jukebox-bitcoinreader.service`
with content
```sh
[Unit]
Description=jukebox-bitcoinreader
After=mysql.service

[Service]
User=jukebox
ExecStart=/usr/bin/php7.0 path/to/readTransactions.php

[Install]
WantedBy=network-online.target
```

and place it to /etc/systemd/system
and then you can run it by systemctl start jukebox-bitcoinreader
