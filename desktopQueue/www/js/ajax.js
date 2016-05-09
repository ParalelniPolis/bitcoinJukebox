function getSongs() {
    $.ajax({
        url: 'www/ajax.php',
        data: {
            request: 'getSongs'
        },
        error: function() {
            alert('Something is broken.');
        },
        dataType: 'json',
        success: function(data) {
            handleSongs(data);
        },
        type: 'GET'
    });
}

function getEmptyQueue() {
    $.ajax({
        url: 'www/ajax.php',
        data: {
            request: 'emptyQueue'
        },
        error: function() {
            alert('Something is broken.');
        },
        dataType: 'json',
        success: function(data) {
            handleSongs(data);
        },
        type: 'GET'
    });
}

var playNextOrLastGenre = function() {
    if (queueList.children().length == 0) {   //queue is empty
        emptyQueue = true;
        state = 'genre';
        getEmptyQueue();
    } else {
        emptyQueue = false;
        playNext();
    }
};

playNextOrLastGenre();
setInterval(function() {
    if(emptyQueue) {
        console.log("asking for songs in empty queue");
        getEmptyQueue();
    } else {
        console.log("asking for songs");
        getSongs();
    }
}, 6000);
