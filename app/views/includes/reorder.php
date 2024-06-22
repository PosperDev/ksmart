<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image']) && isset($_POST['action'])) {
    $imagePath = $_POST['image'];
    $action = $_POST['action'];

    // Obtener todas las imágenes con nombre fijo
    $images = glob('../../data/img/img_*.{jpg,png,gif}', GLOB_BRACE);

    // Ordenar las imágenes según el nombre fijo
    usort($images, function ($a, $b) {
        return (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT) - (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);
    });

    // Buscar el índice de la imagen actual
    $index = array_search($imagePath, $images);

    if ($index !== false) {
        if ($action == 'up' && $index > 0) {
            // Subir imagen
            $temp = $images[$index - 1];
            $images[$index - 1] = $images[$index];
            $images[$index] = $temp;
        } elseif ($action == 'down' && $index < count($images) - 1) {
            // Bajar imagen
            $temp = $images[$index + 1];
            $images[$index + 1] = $images[$index];
            $images[$index] = $temp;
        }

        // Renombrar las imágenes según el nuevo orden
        foreach ($images as $key => $img) {
            $extension = pathinfo($img, PATHINFO_EXTENSION);
            rename($img, "../../data/img/temp_$key.$extension");
        }

        // Volver a renombrar a img_$key.$extension
        foreach ($images as $key => $img) {
            $extension = pathinfo($img, PATHINFO_EXTENSION);
            rename("../../data/img/temp_$key.$extension", "../../data/img/img_$key.$extension");
        }
    }

    // Recargar la página
    header('Location: ../admin/index.php?reload=true&nocache=1234567890');
    exit();
}
?>