<?php

require_once "core/fns.php";

if (isset($_POST['submit'])) {
    $url = $_POST['video_link'];
    $info = extractVideoInfoFromUrl($url);
    $title = $info['title'];
    $both = $info['both'];
    $videoOnly = $info['videoOnly'];
    $audioOnly = $info['audioOnly'];
}
?>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Download YouTube video</title>
    <!-- Font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .formSmall {
            width: 700px;
            margin: 20px auto 20px auto;
        }
    </style>

</head>

<body>
    <div class="container">
        <?php if (!isset($_POST['submit'])) : ?>
            <form method="post" action="" class="formSmall">
                <div class="row">
                    <div class="col-lg-12">
                        <h7 class="text-align"> Download YouTube Video</h7>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input type="text" class="form-control" name="video_link" placeholder="Paste link.. e.g. https://www.youtube.com/watch?v=5cpIZ8zHHXw" <?php 
                            if (isset($_POST['video_link'])) {
                                echo "value='" . $_POST['video_link'] . "'";
                            }else{
                                echo "value='https://www.youtube.com/watch?v=WO2b03Zdu4Q'";
                            } ?>
                                >
                            <span class="input-group-btn">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Go!</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div><!-- .row -->
            </form>
        <?php else : ?>
            <?php
            renderCards($both, "Audio/video", $url, $title);
            renderCards($videoOnly, "VideoOnlu", $url, $title);
            renderCards($audioOnly, "Audio", $url, $title);
            ?>
        <?php endif; ?>
    </div>
</body>

</html>