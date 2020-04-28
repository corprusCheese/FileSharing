<?php


namespace app\other;

use xj\jplayer\AudioWidget;
use xj\jplayer\VideoWidget;

//возвращает html код (для большей читаемости кода)
class HtmlHelper{

    public static function JPlayerAudioHtml(){
        return '<div id="jquery_jplayer_1" class="jp-jplayer"></div>
        <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
            <div class="jp-type-single">
                <div class="jp-gui jp-interface">
                    <div class="jp-row">
                        <div class="jp-controls">
                            <button class="jp-play" role="button" tabindex="0"><i class="fa fa-play"></i></button>
                            <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                        </div>
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                            <div class="jp-time-holder">
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                            </div>
                            <div class="jp-details">
                                <div class="jp-title" aria-label="title">&nbsp;</div>
                            </div>
                        </div>
                        <div class="jp-volume-controls">
                            <button class="jp-mute" role="button" tabindex="0"><i class="fa fa-volume-down"></i></button>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                            <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
                        </div>
                        <div class="jp-toggles">
                            <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
                        </div>
                    </div>
                </div>
                <div class="jp-no-solution">
                    Flash error
                </div>
            </div>
        </div>';
    }

    public static function JPlayerVideoHtml(){
        return '<div id="jp_container_3" class="jp-video" role="application" aria-label="media player">
    <div class="jp-type-single">
        <div class="jp-video-play">
            <button class="jp-video-play-icon" role="button" tabindex="0"><i class="fa fa-play"></i> PLAY</button>
        </div>        
        <div id="jquery_jplayer_3" class="jp-jplayer"></div>        
        <div class="jp-gui">
            <div class="jp-interface">        
                <div class="jp-row">
                    <div class="jp-controls">
                        <button class="jp-play" role="button" tabindex="0"><i class="fa fa-play"></i></button>
                        <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                    </div>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                        <div class="jp-time-holder">
                            <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                            <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                        </div>                    
                        <div class="jp-details">
                            <div class="jp-title" aria-label="title">&nbsp;</div>
                        </div>                
                    </div>        
                    <div class="jp-volume-controls">
                        <button class="jp-mute" role="button" tabindex="0"><i class="fa fa-volume-down"></i></button>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>                
                        <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
                    </div>
                    <div class="jp-toggles">
                        <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
                        <button class="jp-full-screen" role="button" tabindex="0"><i class="fa fa-arrows-alt"></i></button>
                    </div>                        
                </div>
            </div>
        </div>
        <div class="jp-no-solution">
            Flash error
        </div>
    </div>
</div>';
    }

    public static function JPlayerAudioWidget($model, $filePath){
        return AudioWidget::widget([
            'mediaOptions' => [
                'title' => $model->name.'.'.$model->extension,
                'mp3' => $filePath,
                'm4a' => $filePath,
                'oga' => $filePath,
                'fla' => $filePath,
                'wav' => $filePath,
            ],
            'jsOptions' => [
                'supplied' => "mp3, m4a, oga, fla, wav",
                'wmode' => "window",
                'smoothPlayBar' => true,
                'keyEnabled' => true,
                'remainingDuration' => false,
                'toggleDuration' => true,
            ],
            'tagClass' => 'jp-audio',
            'skinAsset' => 'xj\jplayer\skins\BlueAssets',
        ]);
    }

    public static function JplayerVideoWidget($model,$filePath){
        VideoWidget::widget([
            'tagClass' => 'jp-video jp-video-360p',
            'skinAsset' => 'xj\jplayer\skins\BlueAssets', //OR xj\jplayer\skins\PinkAssets
            'mediaOptions' => [
                'title' => $model->name.'.'.$model->extension ,
                'webmv' => $filePath,
                'webma' => $filePath,
                'mp4' => $filePath,
                'ogv' => $filePath,
                'flv' => $filePath,

            ],
            'jsOptions' => [
                'supplied' => "webmv, webma, mp4, ogv, flv",
                'size' => [
                    'width' => "640px",
                    'height' => "360px",
                    'cssClass' => "jp-video-360p"
                ],
                'smoothPlayBar' => true,
                'keyEnabled' => true,
                'remainingDuration' => true,
                'toggleDuration' => true,
            ],
        ]);
    }

}