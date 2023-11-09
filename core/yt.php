<?php


function getVideoInfo($video_id)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{  "context": {    "client": {      "hl": "en",      "clientName": "WEB",      "clientVersion": "2.20210721.00.00",      "clientFormFactor": "UNKNOWN_FORM_FACTOR",   "clientScreen": "WATCH",      "mainAppWebInfo": {        "graftUrl": "/watch?v=' . $video_id . '",           }    },    "user": {      "lockedSafetyMode": false    },    "request": {      "useSsl": true,      "internalExperimentFlags": [],      "consistencyTokenJars": []    }  },  "videoId": "' . $video_id . '",  "playbackContext": {    "contentPlaybackContext": {        "vis": 0,      "splay": false,      "autoCaptionsDefaultOn": false,      "autonavState": "STATE_NONE",      "html5Preference": "HTML5_PREF_WANTS",      "lactMilliseconds": "-1"    }  },  "racyCheckOk": false,  "contentCheckOk": false}');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}


function extractVideoInfoFromUrl($url)
{
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    $video_id = $match[1];
    $video = json_decode(getVideoInfo($video_id));
    $title = $video->videoDetails->title;
    $description = $video->videoDetails->shortDescription;

    $formats1 = $video->streamingData->formats;

    $formats2 = $video->streamingData->adaptiveFormats;

    $formats = array_merge($formats1, $formats2);

    //add flags hasAudioVideo
    foreach ($formats as $format) {
        $format->hasAudio = isset($format->audioQuality);
        $format->hasVideo = strpos($format->mimeType, "video/") !== false;
        $format->hasBothAudioVideo = $format->hasAudio && $format->hasVideo;
        if ($format->hasVideo) {
            $qualityParts = explode("p", $format->qualityLabel, 2);
            $format->qualityLabel2 = $qualityParts[0] . "p";
            $format->isHDR = strpos($qualityParts[1], "HDR") !== false;
        } else {
            $format->qualityLabel2 = "FetchAudio";
            $format->isHDR = false;
        }
    }

    $both = [];
    $videoOnly = [];
    $audioOnly = [];


    foreach ($formats as $format) {
        // dlimit($format->audioQuality);
        if ($format->hasBothAudioVideo) {
            $both[] = $format;
        } else if ($format->hasVideo) {
            $videoOnly[] = $format;
        } else {
            $audioOnly[]  = $format;
        }
    }

    return ["title" => $title, "both" => $both, "videoOnly" => $videoOnly, "audioOnly" => $audioOnly];
}
