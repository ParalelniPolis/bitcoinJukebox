var audioElement = document.getElementById('player');
var queueList = $('#queue-list');

var conn = new WebSocket('ws://localhost:8080');
var state = 'genre';    //state is songs or genre. If state is genre, random songs from chosen genre are played. Genre state is cancelled, when new songs arrive
//default state, on page load, is genre. When some songs arrive, it is changed to songs.
var emptyQueue = true;

var handleSongs = function(songs) {
    var request = songs['request'];     //same string which was sent to server, used to determine, whether new songs arrived or random song from last genre was picked
    console.log(request);
    songs = songs['songs'];
    console.log(songs);
    console.log("getting " + songs.length + " songs");
    if (songs.length > 0 && request == 'getSongs') {
        //if new songs arrived and genre is played, playing of genre has to be immediately stopped
        if(state == 'genre') {
            console.log('removing genre songs from queue');
            while (queueList.children().length > 0) {
                removePlayed();
            }
        }
        state = 'songs';
    }
    for (var i = 0; i < songs.length; i++) {
        emptyQueue = false;
        addToQueue(songs[i]);
    }
};

var addToQueue = function(song) {
    emptyQueue = queueList.children().length == 0;

    var template = $.templates("#songTemplate"); // Get compiled template
    var html = template.render(song);      // Render template using data - as HTML string
    queueList.append(html);

    if(emptyQueue) {
        playNext();
    }
};

var removePlayed = function() {
    console.log("removing played song");
    if (queueList.children().length !== 0) {
        queueList.children()[0].remove();
    }
    if(queueList.children().length == 0) {
        emptyQueue = true;
        console.log("queue is now empty");
    }
};

var playNextOrLastGenre = function() {
    if (queueList.children().length == 0) {   //queue is empty
        emptyQueue = true;
        state = 'genre';
        conn.send('emptyQueue');
    } else {
        emptyQueue = false;
        playNext();
    }
};


var playNext = function() {
    audioElement.src = $(queueList.children()[0]).find('[data-url]').attr('data-url');
    audioElement.play();
};


audioElement.addEventListener('ended', function() {
    removePlayed();
    playNextOrLastGenre();
}, false);

conn.onopen = function() {
    console.log("Connection established!");
    playNextOrLastGenre();
    setInterval(function() {
        if(emptyQueue) {
            console.log("asking for songs in empty queue");
            conn.send('emptyQueue');
        } else {
            console.log("asking for songs");
            conn.send('getSongs');
        }
    }, 6000);
    conn.onmessage = function(event) {
        handleSongs(JSON.parse(event.data));
    }
};

console.log('everything loaded ok');

