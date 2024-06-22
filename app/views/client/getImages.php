<?php
$directory = '../../data/img/';
$images = glob($directory . "*.{jpg,png,gif,jpeg}", GLOB_BRACE);
$imagePaths = array_map(function ($image) {
    return str_replace('../../', '', $image);
}, $images);
echo json_encode($imagePaths);
?>