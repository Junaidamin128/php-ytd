<?php

require_once "core/fns.php";

$videoInfoStr = $_POST['video-info'];
$videoInfo = json_decode($videoInfoStr);

$name = downloadYotubeVideoFromUrl($videoInfo->url);
// header("Location: ".BASE_URI."dtd.php?name=".$name);
header("Location: ".BASE_URI.$name);





if($videoInfo->hasBothAudioVideo)
{
    //download stright
}else if(!$videoInfo->hasVideo)
{
    //download stright audio
}else{
    //video download
    //audio download
    //merge
}