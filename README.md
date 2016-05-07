TV viewport resolution: 962 x 453

how to run it:

Start websocket server:
```sh
$ php desktopQueue/bin/run-server.php
```

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