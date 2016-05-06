#!/usr/bin/env bash
git pull
php desktopQueue/composer.phar update
php adminAndMobile/composer.phar update
sudo systemctl restart jukebox-websocket
sudo systemctl restart jukebox-bitcoinreader
