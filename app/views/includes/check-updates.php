<?php
$images = glob('../../data/img/img_*.{jpg,png,gif}', GLOB_BRACE);
$lastModified = 0;

foreach ($images as $image) {
    $modifiedTime = filemtime($image);
    if ($modifiedTime > $lastModified) {
        $lastModified = $modifiedTime;
    }
}

header('Content-Type: application/json');
echo json_encode(['lastUpdate' => $lastModified]);
?>