<?php
session_start();

// Leer el archivo JSON
$jsonString = file_get_contents('../../config/config.json');

// Decodificar el JSON en un array PHP
$config = json_decode($jsonString, true);

// Obtener el valor de 'time' y multiplicarlo por 1000
$timeInMilliseconds = $config['time'] * 1000;

// Obtener el valor de 'time' y multiplicarlo por 1000
$timeInMilliseconds2 = $config['slideTime'] * 1000;

// Asignar el valor a la variable de sesión
$_SESSION['showTime'] = $timeInMilliseconds;

$_SESSION['slideTime'] = $timeInMilliseconds2;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Client</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="../../../public/css/client.css" rel="stylesheet">
</head>

<body class="bg-white-100">
	<!-- Carrusel -->
	<div class="carousel-container" id="carousel">
		<div id="carousel-background" class="carousel-background"></div>
		<div id="carousel" class="carousel">
			<div id="carousel-inner" class="carousel-inner">
				<!-- Las imágenes se insertarán aquí -->
			</div>
		</div>
	</div>

	<div id="btnin">
		<input type="text" id="barcode" autofocus />
		<label id="barcodeLabel"></label>
	</div>

	<!-- Logo -->
	<div id="logo" class="logo hidden">
		<img src="../../data/logo/image.png" alt="Logo">
	</div>

	<!-- Footer -->
	<div id="footer" class="footer hidden">
		<img src="../../data/footer/image.jpg" alt="Footer">
	</div>

	<script>
		// Pasar la variable de sesión de PHP a JavaScript
		const showTimeVar = <?php echo $_SESSION['showTime']; ?>;
		const slideTime = <?php echo $_SESSION['slideTime']; ?>;
		const show = <?php echo $config['show']; ?>;
		let currentIndex = 0;
		const carousel = document.getElementById('carousel');
		const barcodeInput = document.getElementById('barcode');
		const barcodeLabel = document.getElementById('barcodeLabel');
		const logo = document.getElementById('logo');
		const footer = document.getElementById('footer');

		async function fetchImages() {
			const response = await fetch('getImages.php');
			const images = await response.json();
			const carouselInner = document.getElementById('carousel-inner');
			images.forEach(image => {
				const imgDiv = document.createElement('div');
				imgDiv.classList.add('carousel-item');
				imgDiv.innerHTML = `<img src="../../${image}" class="w-full">`;
				carouselInner.appendChild(imgDiv);
			});
			showSlide(currentIndex);
			setInterval(nextSlide, slideTime); // Cambia cada 3 segundos
		}

		function showSlide(index) {
			const slides = document.querySelectorAll('.carousel-item');
			const carouselInner = document.getElementById('carousel-inner');
			carouselInner.style.transform = `translateX(-${index * 100}%)`;
			updateBackground(slides[index].querySelector('img').src);
		}

		function nextSlide() {
			const slides = document.querySelectorAll('.carousel-item');
			currentIndex = (currentIndex + 1) % slides.length;
			showSlide(currentIndex);
		}

		function updateBackground(imageUrl) {
			const carouselBackground = document.getElementById('carousel-background');
			carouselBackground.style.backgroundImage = `url(${imageUrl})`;
		}

		window.onload = function () {
			fetchImages();
			barcodeInput.classList.remove('active'); // Inicialmente oculto
			if (show === 1) {
				logo.classList.remove('hidden');
				footer.classList.remove('hidden');
			}
		};

		// Función searchItem
		function searchItem() {
			carousel.style.visibility = 'hidden';
			setTimeout(function () {
				barcodeLabel.textContent = barcodeInput.value;
				barcodeLabel.classList.add('active');
				if (show === 0) {
					logo.classList.remove('hidden');
					footer.classList.remove('hidden');
				}
			}, 500); // Esperar 200 ms antes de ejecutar la lógica
			setTimeout(function () {
				carousel.style.visibility = 'visible';
				barcodeInput.value = "";
				barcodeLabel.classList.remove('active');
				if (show === 0) {
					logo.classList.add('hidden');
					footer.classList.add('hidden');
				}
			}, showTimeVar); // Esperar showTimeVar milisegundos antes de ejecutar la lógica
		}

		$("#barcode").keypress(function (event) {
			searchItem();
			if (event.keyCode === 13) {
				event.preventDefault();
			}
		});

		let lastUpdate = null;

		function checkForUpdates() {
			fetch('../includes/check-updates.php')
				.then(response => response.json())
				.then(data => {
					if (lastUpdate === null) {
						lastUpdate = data.lastUpdate;
						console.log(lastUpdate);
					} else if (lastUpdate !== data.lastUpdate) {
						location.reload(true);
					}
				})
				.catch(error => console.error('Error checking for updates:', error));
		}

		// Check for updates every 10 seconds
		setInterval(checkForUpdates, 10000);
	</script>
</body>

</html>