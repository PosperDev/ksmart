<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<title>Kiosco Posper</title>
<script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> 
</script> 
</head>
<body onload="hideinfo()">

<div id="vprecio">
	
	<img class="logo" src="<?php $dir = 'pimg/logo/'; $dir_handle = opendir($dir);  while(($file_name = readdir($dir_handle)) !== false) 
      	{ if (strlen($file_name)>3) { echo $dir.$file_name; }}?>">
	<br><h5 id="tituloprecio">PRECIO:</h5><br>
	<p><h1 id="preciov"></h1></p>
	<p><h4 id="nombrev"></h4></p>
	<p><h8 id="descripv"></h3></p>
		<div class="abajo">
			<img src="<?php $dirf = 'pimg/footer/'; $dirf_handle = opendir($dirf);  while(($file_name = readdir($dirf_handle)) !== false) 
      { if (strlen($file_name)>3) { echo $dirf.$file_name; }}?>">
		</div>
	</div>
	

<div id="vid" class="slideshow-container" onclick="refocus()">

	<?php
		$dir_handle = opendir("img/");
		while(($file_name = readdir($dir_handle)) !== false) 
		{ 
			if (strlen($file_name)>3)
			{
				echo '<div class="mySlides fade">';
				echo '<img src="img/'.$file_name.'" class="imagenesslideshow" onclick="refocus()">';
				echo '</div>';
			}
		}
		closedir($dir_handle);
	?>

</div>

<div id="btnin">
	<input type="text" id="txtcodein" autofocus />
</div>

<div class="hide" id="content">

<p style="clear:both"><br>
<script>  
	var content = document.getElementById("content");
	var vid = document.getElementById("vid");
	var vprecio = document.getElementById("vprecio");
	var temporizador;
	var pejemplo = "";
	var nejemplo = "";
	var dejemplo="";
	var fejemplo = "";
	
	
	$("#txtcodein").keypress(function(event) { 
	
         if (event.keyCode === 13) { 
			var input = document.getElementById("txtcodein").value;
			
			clearTimeout(temporizador);
			parse(input);
		 } 
     }); 
	function parse(input) 
	{	
		if (!isNaN(input)){
			buscacodigo(input);
			input = "";
		}

	}
	
	function buscacodigo(input) {
		vfprecio(input,pejemplo,nejemplo,dejemplo);
		hidevideo();
	}
			 
	function hideinfo() {
		vid.style.display = "block";
		vprecio.style.display="none";
	 }
	 
	function hidevideo() {
	document.getElementById("txtcodein").value = "";
	vprecio.style=display = "flex";
	temporizador = setTimeout(function(){
		vprecio.style.display = "none";
		//document.getElementById("codinput").innerHTML = "";
		document.getElementById("preciov").innerHTML = "";
		//document.getElementById("descripv").innerHTML = "";
		document.getElementById("nombrev").innerHTML = "";
		//document.getElementById("fotov").src = "";
		},6000);
	}

function vfprecio(input,pejemplo,nejemplo) {
	return $.ajax({	
		url:'consulta.php',
		data: {
			"cia":"001",
			"codigo":input,
			"json":"1",
			"token":999994,
		},
		cache:false,
		type: "GET",
		success: function(data) {
			response=$.parseJSON(data);
			haypromo=response['haypromo'];
			preciopromo=response['vpromo']
			nejemplo=response['desc_general']
			pejemplo=response['precio_new']
			muestratxt(haypromo,preciopromo,nejemplo,pejemplo,'','');
		},
		error: function (xhr) {
			muestratxt(0,'','Codigo no encontrado','','','');
		}
	}); 


	
}

/*
	function vfprecio(input,pejemplo,nejemplo) { //funcion de verificacion de precios
		return $.ajax({
			url:'http://maylnxwebd01.machetazo.com/reportes/php/consultapreciosXML_TEST.php?cia=001&codigo='.input.'&json=1&token=999994', //se envia el codigo capturado a traves de ajax
			type:'GET',
			input:input,
			contentType:'application/json',
			dataType:'text',
			cache:false,
			processData:false,
			success:function(data){ // se reciben los datos resultantes
				response=$.parseJSON(data);
				//nejemplo=response['desc_general']
				//pejemplo=response['precio_new']
				//haypromo
				//vpromo
	
				muestratxt(nejemplo,pejemplo,'','');
				console.log("nejemplo:"+nejemplo+"  pejemplo:"+pejemplo);
			},
			error:function(ts){
				console.log(ts.responseText);//$("#senderMsg").html("Error en AJAX ");
			}
		});
	*/
	function dolla(precio){
		if (precio < 1) { precio = "0"+precio.toString();}  // If less than a dollar, format the value to display correctly
		var p = parseFloat(precio,10); 
		var pi =p.toFixed(2);
		return pi;
	}
	function muestratxt(haypromo,preciopromo,nombre,precio,descrip,codigo) {
		
		var pi=dolla(precio);
		if (haypromo == 1) {
			document.getElementById("tituloprecio").innerHTML = "PRECIO REGULAR: B/."+pi+"<br>PRECIO PROMOCIONAL:";
			document.getElementById("nombrev").innerHTML = nombre; // gets the object and assigns the value
			document.getElementById("descripv").innerHTML = descrip; // gets the object and assigns the value
			var ppromo = dolla(preciopromo);
			document.getElementById("preciov").innerHTML = "B/."+ppromo;
		}
		else {
			document.getElementById("nombrev").innerHTML = nombre; // gets the object and assigns the value
		document.getElementById("descripv").innerHTML = descrip; // gets the object and assigns the value
		
		console.log(pi);
		document.getElementById("preciov").innerHTML = "B/."+pi;
		}
		
	}
// aca comienza el otro codigo

	var slideIndex = 0;
	showSlides();

function showSlides() {
       var i;
       var slides = document.getElementsByClassName("mySlides");
       for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
       }
       slideIndex++;
       if(slideIndex > slides.length) {slideIndex = 1}
       slides[slideIndex-1].style.display = "block";
       setTimeout(showSlides,<?php $myfile = fopen("conf/settings.txt", "r") or die("Unable to open file!"); echo fread($myfile,filesize("conf/settings.txt"));  fclose($myfile); ?>);
   
}

function refocus() {
	$('#txtcodein').focus();

}
</script>

</div>
</body>
</html>