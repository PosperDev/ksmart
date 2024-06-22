<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['newImage'])) {
    $targetDir = "../../data/img/";
    $imageFileType = strtolower(pathinfo($_FILES['newImage']['name'], PATHINFO_EXTENSION));

    // Obtener el próximo número de imagen
    $images = glob($targetDir . "*.{jpg,png,gif}", GLOB_BRACE);
    usort($images, function ($a, $b) {
        return (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT) - (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);
    });
    $lastImage = end($images);
    $nextIndex = $lastImage ? (int) filter_var($lastImage, FILTER_SANITIZE_NUMBER_INT) + 1 : 0;
    $newImageName = "img_" . $nextIndex . "." . $imageFileType;

    // Mover la imagen subida al directorio de destino
    $targetFilePath = $targetDir . $newImageName;
    if (move_uploaded_file($_FILES['newImage']['tmp_name'], $targetFilePath)) {
        // Redirigir de vuelta a la página con el parámetro de reload para actualizar la lista de imágenes
        header("Location: ../admin/index.php?reload=true");
        exit;
    } else {
        echo "Hubo un problema al subir la imagen.";
    }
}
?>