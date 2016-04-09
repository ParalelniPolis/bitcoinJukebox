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
