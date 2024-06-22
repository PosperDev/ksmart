<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$targetDir = "../../data/";
$footerDir = $targetDir . "footer/";
$logoDir = $targetDir . "logo/";

function replaceImage($dir, $inputName)
{
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$inputName]['tmp_name'];
        $fileName = $_FILES[$inputName]['name'];
        $fileSize = $_FILES[$inputName]['size'];
        $fileType = $_FILES[$inputName]['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar el tipo de archivo
        $allowedfileExtensions = ['jpg', 'gif', 'png'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Eliminar la imagen anterior
            $oldImages = glob($dir . "*.{jpg,png,gif}", GLOB_BRACE);
            foreach ($oldImages as $oldImage) {
                unlink($oldImage);
            }

            // Mover la nueva imagen
            $dest_path = $dir . "image." . $fileExtension;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                return true;
            }
        }
    }
    return false;
}

$footerUploaded = replaceImage($footerDir, 'footerImage');
$logoUploaded = replaceImage($logoDir, 'logoImage');

header("Location: ../admin/index.php?upload_success=" . ($footerUploaded && $logoUploaded));
exit;
?>