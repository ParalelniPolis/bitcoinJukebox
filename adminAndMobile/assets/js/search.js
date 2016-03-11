(function ($) {

    $('#frm-searchForm').submit(function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        var searchedText = $('#frm-searchForm').find(':input').val();
        var searchedTextRegex = new RegExp(searchedText, "igm");
        var songs = $('#frm-orderForm').find('> div');
        for (var i = 0; i < songs.length; i++) {    //can be song or genre
            var song = $(songs[i]);
            var isSong = song.find('label').length > 0;
            var songText;
            if (isSong) {
                songText = song.find('label').text();
            } else {
                songText = song.text();
            }

            var matches = searchedTextRegex.exec(songText) != null;
            if (matches) {
                song.show("slow");
            } else {
                song.hide("slow");
            }
        }
        return false;
    });


})(jQuery);