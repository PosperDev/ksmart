<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image'])) {
    $imagePath = $_POST['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    header('Location: ../admin/index.php');
    exit();
}
?>