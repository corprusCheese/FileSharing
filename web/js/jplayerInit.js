//инициализация плееров
// первый - аудио, второй - видео

$(document).ready(function(){

    var filepathAudio = '../uploads/music/';
    if (window.location.href.indexOf('admin'))
        filepathAudio = '../../uploads/music/';
    var name = $('.my-info').attr('name');
    filepathAudio+=name;
    $("#jquery_jplayer_1").jPlayer({
        ready: function (event) {
            $(this).jPlayer("setMedia", {
                title: name,
                mp3: filepathAudio,
                oga: filepathAudio,
                fla: filepathAudio,
                m4a: filepathAudio,
                wav: filepathAudio,
            });
        },
        cssSelectorAncestor: "#jp_container_1",
        supplied: "mp3, m4a, oga, fla, wav",
        wmode: "window",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
    });
});

$(document).ready(function(){
    var filepathVideo = '../uploads/video/';
    if (window.location.href.indexOf('admin'))
        filepathAudio = '../../uploads/video/';
    var name = $('.my-info').attr('name');
    filepathVideo+=name;
    $("#jquery_jplayer_3").jPlayer({
        ready: function () {
            $(this).jPlayer("setMedia", {
                title: name,
                m4v: filepathVideo,
                ogv: filepathVideo,
                webmv: filepathVideo,
                flv: filepathVideo,
                webma: filepathVideo,
            });
        },
        cssSelectorAncestor: "#jp_container_3",
        supplied: "webmv, ogv, m4v, flv, webma",
        size: {
            width: "100%",
            height: "540px"
        },
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
    });
    var clickHandler = function(event) {
        event.preventDefault();
        var $jp = $('#jquery_jplayer_3');
        var status = $jp.data('jPlayer').status;
        if(status.paused) {
            $jp.jPlayer('play');
        } else {
            $jp.jPlayer('pause');
        }
    };
    $('#jquery_jplayer_3').on("click", clickHandler);
    $('#jquery_jplayer_3').on($.jPlayer.event.click, clickHandler);
});