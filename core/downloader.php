<?php

function downloadYotubeVideoFromUrl($url)
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        return downloadUsingWinWget($url);
    } else {
        return downloadUsingLinuxWget($url);
    }
}



function downloadUsingWinWget($url)
{
    $name =  "video-" . date(" m-i") . ".mp4";
    $command = "D:/xampp/htdocs/ytd/3rd/wget.exe -O \"$name\" \"$url\"";
    // benchStart("Shell");
    // s(shell_exec($command));
    // benchEnd();

    // benchStart("exec");
    $return = exec($command, $output, $result_code);
    // benchEnd();
    return $name;
}

function downloadUsingLinuxWget()
{
    echo "Server is linux and no wget setup";
    exit;
}
