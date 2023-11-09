<?php
function renderCards($formats, $cardHeader = "", $url = "", $title = "")
{
?>
    <div class="card formSmall">
        <div class="card-header">
            <strong><?= $cardHeader; ?></strong>
        </div>

        <div class="card-body">
            <table class="table ">
                <tr>
                    <td>Type</td>
                    <td>Quality</td>
                    <td>Action</td>
                </tr>
                <tr>
                    <h2 href="<?php echo $url; ?>"><?= $title; ?></h2>
                </tr>
                <?php foreach ($formats as $format) : ?>
                    <?php

                    if (@$format->url == "") {
                        $signature = "https://example.com?" . $format->signatureCipher;
                        parse_str(parse_url($signature, PHP_URL_QUERY), $parse_signature);
                        $url = $parse_signature['url'] . "&sig=" . $parse_signature['s'];
                    } else {
                        $url = $format->url;
                    }
                    ?>
                    <tr>

                        <td>
                            <?= explode(";", $format->mimeType)[0]; ?>
                            <?php //if ($format->mimeType) echo explode(";", explode("/", $format->mimeType)[1])[0];
                            //else echo "Unknown"; 
                            ?>
                        </td>
                        <td>
                            <?= $format->qualityLabel2 ?>
                            <?= isset($format->fps) ? "<span class='badge badge-primary'>" . $format->fps . "</span>" : "" ?>
                            <?= $format->isHDR ? "<span class='is-hdr badge badge-secondary badge-xs'>HDR</span>" : "" ?>
                        </td>
                        <td>
                            <a href="downloader.php?link=<?php echo urlencode($url) ?>&title=<?php echo urlencode($title) ?>&type=<?php if ($format->mimeType) echo explode(";", explode("/", $format->mimeType)[1])[0];
                                                                                                                                    else echo "mp4"; ?>">
                                Download
                            </a>
                            <textarea><?= $format->url; ?></textarea>
                            <form method="post" action="<?= BASE_URI; ?>download2.php">
                                <textarea name="video-info"><?= json_encode($format) ?></textarea>
                                <button>Download</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php
}