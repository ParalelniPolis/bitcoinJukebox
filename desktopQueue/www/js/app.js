var data = JSON.parse(document.getElementById('test').innerHTML);
var songsWrapper  = document.getElementById('songs-wrapper');
var audioElement = document.getElementById('player');
var queueList = document.getElementById('queue-list');

var conn = new WebSocket('ws://localhost:8080');
var state = 'songs';    //state is songs or genre. If state is genre, random songs from chosen genre are played. Genre state is cancelled, when new songs arrive

conn.onopen = function() {
    console.log("Connection established!");
    setInterval(function() {
        conn.send('getSongs');
        //if(state == 'songs') {
        //} else if (state == 'genre') {
        //    //nothing
        //} else {
        //    console.log('fuck, I am in invalid state.');
        //}
    }, 6000);
    conn.onmessage = function(event) {
        handleSongs(JSON.parse(event.data));
    }
};


var handleSongs = function(songs) {
    if (songs.length > 0) {
        state = 'songs';
    }
    for (var i = 0; i < songs.length; i++) {
        addToQueue(songs[i]);
    }
};

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
};

var removePlayed = function() {
    if (queueList.children.length !== 0) {
        queueList.removeChild(queueList.children[0]);
    }
};

var playNextOrLastGenre = function() {
    if (queueList.children.length == 0) {   //queue is empty
        state = 'genre';
        conn.send('emptyQueue');
    }
    playNext();
};


var playNext = function() {
    audioElement.src = queueList.children[0].getAttribute('data-url');
    audioElement.play();
};

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

playNextOrLastGenre();

audioElement.addEventListener('ended', function() {
    removePlayed();
    playNextOrLastGenre();
}, false);
