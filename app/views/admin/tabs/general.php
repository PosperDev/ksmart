<?php
// Obtener la configuración general
$generalConfig = $configManager->getGeneral();
?>

<div id="general-tab" class="tab-content bg-white p-6 rounded shadow-lg mb-6" style="display: block;">
    <form id="general-form" class="general-form bg-white p-6 rounded shadow-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Configuración</h3>
        <div class="mb-4">
            <label for="slideTime" class="block text-gray-700">Tiempo de Slider: (En segundos)</label>
            <input type="number" id="slideTime" name="slideTime" value="<?php echo $generalConfig['slideTime']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="time" class="block text-gray-700">Tiempo de información: (En segundos)</label>
            <input type="number" id="time" name="time" value="<?php echo $generalConfig['time']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="show" class="block text-gray-700">Mostrar Logo y Footer:</label>
            <select id="show" name="show" class="w-full px-3 py-2 border rounded">
                <option value="1" <?php echo $generalConfig['show'] == 1 ? 'selected' : ''; ?>>Siempre</option>
                <option value="0" <?php echo $generalConfig['show'] == 0 ? 'selected' : ''; ?>>Solo al buscar</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Configuración</button>
    </form>

    <form id="interface-config-form" class="interface-config-form bg-white p-6 rounded shadow-lg mb-6"
        enctype="multipart/form-data" method="post" action="../includes/upload.php">
        <h3 class="text-xl font-semibold mb-4">Configuración de Interfaz</h3>
        <div class="mb-4">
            <label for="footerImage" class="block text-gray-700">Imagen del Footer:</label>
            <!-- Mostrar la imagen del footer -->
            <li class='mb-4'>
                <?php
                $footerImages = glob('../../data/footer/*.{jpg,png,gif}', GLOB_BRACE);
                foreach ($footerImages as $footerImage) {
                    echo "<img src='$footerImage' alt='Footer Image' class='object-cover mb-2'>";
                }
                ?>
            </li>
            <input type="file" id="footerImage" name="footerImage" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="logoImage" class="block text-gray-700">Logo:</label>
            <!-- Mostrar la imagen del logo -->
            <li class='mb-4'>
                <?php
                $logoImages = glob('../../data/logo/*.{jpg,png,gif}', GLOB_BRACE);
                foreach ($logoImages as $logoImage) {
                    echo "<img src='$logoImage' alt='Logo Image' class='object-cover mb-2'>";
                }
                ?>
            </li>
            <input type="file" id="logoImage" name="logoImage" class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Imágenes</button>
    </form>

    <div class="current-images bg-white p-6 rounded shadow-lg mb-6">
        <form id="upload-image-form" class="upload-image-form bg-white p-6 rounded shadow-lg mb-6"
            enctype="multipart/form-data" method="post" action="../includes/upload_image.php">
            <h3 class="text-xl font-semibold mb-4">Subir Nueva Imagen</h3>
            <div class="mb-4">
                <label for="newImage" class="block text-gray-700">Nueva Imagen:</label>
                <input type="file" id="newImage" name="newImage" class="w-full px-3 py-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Subir Imagen</button>
        </form>
        <h3 class="text-xl font-semibold mb-4">Imágenes Actuales</h3>
        <ul id="image-list">
            <?php
            // Establecer encabezados para evitar el almacenamiento en caché de las imágenes
            //header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            //header("Cache-Control: post-check=0, pre-check=0", false);
            //header("Pragma: no-cache");

            // Obtener la lista de imágenes
            $images = glob('../../data/img/*.{jpg,png,gif}', GLOB_BRACE);
            usort($images, function ($a, $b) {
                return (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT) - (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);
            });

            // Mostrar las imágenes
            foreach ($images as $image) {
                $imageName = basename($image);
                echo "<li class='mb-4'>";
                echo "<img src='$image' alt='$imageName' class='w-20 h-20 object-cover mb-2'>";
                echo "<form action='../includes/delete.php' method='post' class='inline'>";
                echo "<input type='hidden' name='image' value='$image'>";
                echo "<button type='submit' class='bg-red-500 text-white px-4 py-2 rounded'>Eliminar</button>";
                echo "</form>";
                echo "<form action='../includes/reorder.php' method='post' class='inline ml-2'>";
                echo "<input type='hidden' name='image' value='$image'>";
                echo "<button type='submit' name='action' value='up' class='bg-yellow-500 text-white px-4 py-2 rounded'>Subir</button>";
                echo "<button type='submit' name='action' value='down' class='bg-yellow-500 text-white px-4 py-2 rounded'>Bajar</button>";
                echo "</form>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
</div>

<!-- JavaScript para actualizar dinámicamente la lista de imágenes después de la reordenación -->
<script>
    // Obtener los parámetros de la URL
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    // Obtener el valor de 'reload'
    const reload = urlParams.get('reload');
    console.log('Valor de reload:', reload);

    // Si existe el parámetro 'reload', eliminarlo de los parámetros de la URL
    if (reload) {
        urlParams.delete('reload');

        // Crear una nueva URL sin el parámetro 'reload'
        const newUrl = window.location.pathname + '?' + urlParams.toString();

        // Redirigir a la nueva URL
        window.history.replaceState({}, document.title, newUrl);

        // Recargar la página forzando la recarga desde el servidor
        location.reload(true);
    }
</script>