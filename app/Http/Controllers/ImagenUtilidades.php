<?php

/**
 * Función que tiene que recibir la ruta de una imagen de nuestro servidor web
 * y devuelve un array con los colores mas utilizados para el rojo, verde y azul
 * Si no devuelve una imagen conocida, devuelve array(0,0,0)
 */
function getAverageColor($rutaImagen): array
{
	// color por defecto rgb(1,22,39)
	$colorDefault =	array(1, 22, 39);

	// usamos un try catch para evitar que el programa se detenga si la imagen no existe
	try {
		// todas las imagenes deben estar en la carpeta storage...
		$rutaImagen = 'storage/' . $rutaImagen;

		// obtenemos el tipo mime de la imagen (desde PHP 5.3)
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$fileMime = finfo_file($finfo, $rutaImagen);

		// abrimos la imagen
		if ($fileMime == "image/jpeg" || $fileMime == "image/pjpeg") {
			$imgId = imagecreatefromjpeg($rutaImagen);
		} else if ($fileMime == "image/gif") {
			$imgId = imagecreatefromgif($rutaImagen);
		} else if ($fileMime == "image/png") {
			$imgId = imagecreatefrompng($rutaImagen);
		} else {
			return $colorDefault;
		}

		$red = 0;
		$green = 0;
		$blue = 0;
		$total = 0;

		// Recorremos todos los valores horizontales
		for ($x = 0; $x < imagesx($imgId); $x++) {
			// Recorremos todos los valores verticales
			for ($y = 0; $y < imagesy($imgId); $y++) {
				// Obtenemos los valores red, green, blue de cada pixel de la imagen
				// (http://php.net/manual/en/function.imagecolorat.php)
				$rgb = imagecolorat($imgId, $x, $y);

				// devuelve el indice de cada color
				$red += ($rgb >> 16) & 0xFF;
				$green += ($rgb >> 8) & 0xFF;
				$blue += $rgb & 0xFF;

				$total++;
			}
		}
		$redPromedio = round($red / $total);
		$greenPromedio = round($green / $total);
		$bluePromedio = round($blue / $total);

		// devolvemos un array con el promedio de los colores en rojo, verde y azul
		return array($redPromedio, $greenPromedio, $bluePromedio);
	} catch (Exception $e) {
		return $colorDefault;
	}
}
