<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$identificador = $_POST["identificador"];
$enunciado = $_POST["enunciado"];
$anio_creacion = $_POST["anio_creacion"];
$nivel_dificultad = $_POST["nivel_dificultad"];
$pregunta_madre = $_POST["pregunta_madre"];

// Query SQL a la BD. 
$query = "INSERT INTO `pregunta`(`identificador`,`enunciado`, `anio_creacion`, `nivel_dificultad`,`pregunta_madre`) VALUES ('$identificador', '$enunciado', '$anio_creacion', '$nivel_dificultad','$pregunta_madre')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: pregunta.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);