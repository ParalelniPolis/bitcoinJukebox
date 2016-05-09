var conn;
if (document.location.hostname == "localhost" || document.location.hostname.indexOf('192.168') > -1) {
    conn = new WebSocket('ws://' + document.domain + ':10666');
} else {
    conn = new WebSocket('ws://' + document.domain + '/ws/');
}


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
