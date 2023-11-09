<?php
define("BASE_URI",  "/ytd/");

require_once("downloader.php");
require_once("view.php");
require_once("yt.php");

$time = 0;
$benchTitle = "";
function benchStart($title = "Bench")
{
    global $benchTitle;
    global $time;
    $time = time();
    $benchTitle = $title;
}

function benchEnd(){
    global $benchTitle;
    global $time;
    $time2 = time();
    echo "<h1>Benchmark $benchTitle (".($time2-$time)." seconds)</h1>";
}