var data = JSON.parse(document.getElementById('test').innerHTML);
var songsWrapper  = document.getElementById('songs-wrapper');
var audioElement = document.getElementById('player');
var queueList = document.getElementById('queue-list');

var filterAddr = function(obj) {
    if(obj.addr == '15iuRwGSiUTknHJtoP4CJ3dHUr8T4vQuaE') {
        return true;
    }
    else {
        return false;
    }
}

var handleSong = function(songs) {
    for (i = 0; i < songs.length; i++) {
        addToQueue(songs[i]);
    }
}

var addToQueue = function(song) {
    var emptyList = queueList.children.length == 0;
    var item = document.createElement('a');
    item.className = 'mdl-navigation__link';

    console.log(song.location);
    console.log(song.name);
    item.setAttribute('data-url', song.location);
    item.textContent = song.name;

    queueList.appendChild(item);

    if(emptyList) {
        playNext();
    }
}

var removePlayed = function() {
    if (queueList.children.length !== 0) {
        queueList.removeChild(queueList.children[0]);
    }
}

var playNextOrShuffle = function() {
    if (queueList.children.length == 0) {
        playShuffle();
    }
    else {
        playNext();
    }
}

var playShuffle = function() {
    var rand = Math.floor(Math.random() * data.length);

    audioElement.src = data[rand].url;
    audioElement.oncanplay = function() {
        setTimeout(function() {
            audioElement.play()
        }, 1000);
    }
}

var playNext = function() {
    audioElement.src = queueList.children[0].getAttribute('data-url');
    audioElement.play();
}

data.map(function(songData, index) {
    var songWrap = document.createElement('div')
    var song  = document.createElement('div');
    var header = document.createElement('div');
    var title = document.createElement('h2');
    var qr = document.createElement('div');
    var meta = document.createElement('p');

    songWrap.className = 'mdl-cell mdl-cell--3-col'
    song.className = 'mdl-card mdl-shadow--2dp';
    header.className = 'mdl-card__title';
    title.className = 'mdl-card__title-text';
    qr.className = 'mdl-card__media';
    meta.className = 'mdl-card__supporting-text';

    var count = index + 1;
    var songId = count.toString(10);

    if(songId.length < 2) {
        songId = '0' + songId;
    }
    if(songId.length < 3) {
        songId = '0' + songId;
    }

    title.textContent = songData.title + ' - ' + songData.artist;
    song.setAttribute('title', songData.title + ' - ' + songData.artist);
    song.setAttribute('data-song-id', songId);
    song.setAttribute('data-song-url', songData.url);
    new QRCode(qr, {
        text: 'bitcoin:15iuRwGSiUTknHJtoP4CJ3dHUr8T4vQuaE?amount=0.00010' + songId + '&message=Jukebox',
        correctLevel : QRCode.CorrectLevel.L
    });
    meta.textContent = 'Duration: ' + songData.duration;

    header.appendChild(title);
    song.appendChild(header);
    song.appendChild(qr);
    song.appendChild(meta);
    songWrap.appendChild(song);

    songsWrapper.appendChild(songWrap);
});

playNextOrShuffle();

audioElement.addEventListener('ended', function() {
    removePlayed();
    playNextOrShuffle();
}, false);

//var ws = new WebSocket('wss://ws.blockchain.info/inv');
//ws.onopen = function() {
//    setInterval(function() {
//        ws.send(JSON.stringify({'op':'addr_sub', 'addr':'15iuRwGSiUTknHJtoP4CJ3dHUr8T4vQuaE'}))
//    }, 60000);
//    ws.onmessage = function(event) {
//        console.log(JSON.parse(event.data));
//        handleSong(JSON.parse(event.data));
//    }
//}

var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
        console.log(JSON.parse(e.data));
        handleSong(JSON.parse(e.data));
};