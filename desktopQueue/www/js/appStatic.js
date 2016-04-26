/** @type HTMLMediaElement */
var audioElement = document.getElementById('player');
var queueList = $('#queue-list');

var conn;
// if (document.location.hostname == "localhost" || document.location.hostname.indexOf('192.168') > -1) {
//     conn = new WebSocket('ws://' + document.domain + ':10666');
// } else {
//     conn = new WebSocket('ws://' + document.domain + '/ws/');
// }
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
    queueList.find('.album-icon-wrapper img[src=\'\']').hide();

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
        // conn.send('emptyQueue');
    } else {
        emptyQueue = false;
        playNext();
    }
};

var playNext = function() {
    var firstInQueue = $(queueList.children()[0]);
    audioElement.src = window.location.href.replace('static.php', '') + '../../' + firstInQueue.find('[data-url]').attr('data-url');
    var audioContainer = $('#audio-container');
    audioContainer.find('.mejs-duration').text(firstInQueue.find('[data-duration]').attr('data-duration'));
    audioElement.play();
    firstInQueue.addClass('active');
};


audioElement.addEventListener('ended', function() {
    removePlayed();
    playNextOrLastGenre();
}, false);

playNextOrLastGenre();
// conn.onopen = function() {
//     console.log("Connection established!");
//     playNextOrLastGenre();
//     setInterval(function() {
//         if(emptyQueue) {
//             console.log("asking for songs in empty queue");
//             conn.send('emptyQueue');
//         } else {
//             console.log("asking for songs");
//             conn.send('getSongs');
//         }
//     }, 6000);
//     conn.onmessage = function(event) {
//         handleSongs(JSON.parse(event.data));
//     }
// };

toMMSS = function (sec_num) {
    //var sec_num = parseInt(this, 10); // don't forget the second param
    var minutes = Math.floor(sec_num / 60);
    var seconds = Math.floor(sec_num - (minutes * 60));

    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return minutes + ':' + seconds;
};

fromMMSS = function (string) {
    var time = string.split(':');
    //var sec_num = parseInt(this, 10); // don't forget the second param
    var minutes = time[0];
    var seconds = time[1];

    return parseInt(minutes) * 60 + parseInt(seconds);
};

console.log('everything loaded ok');

//audioplayer animation
setInterval(function() {
    var audioContainer = $('#audio-container');
    var currentTime = Math.floor(audioElement.currentTime);
    var totalTime = fromMMSS(audioContainer.find('.mejs-duration').text());
    audioContainer.find('.mejs-currenttime').text(toMMSS(currentTime));
    var playedRatio = currentTime / totalTime;
    var totalWidth = audioContainer.find('.mejs-time-loaded').width();
    audioContainer.find('.mejs-time-current').width(playedRatio * totalWidth);
}, 250);

window.onerror = function (e) {
    alert(e);
}