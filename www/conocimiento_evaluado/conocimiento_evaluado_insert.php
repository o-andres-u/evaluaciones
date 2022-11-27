<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$tema_evaluado = $_POST["tema_evaluado"];
$pregunta_asignada = $_POST["pregunta_asignada"];
$peso = $_POST["peso"];


// Query SQL a la BD
$query = "INSERT INTO `conocimiento_evaluado`(`tema_evaluado`,`pregunta_asignada`, `peso`) VALUES ('$tema_evaluado', '$pregunta_asignada', '$peso')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: conocimiento_evaluado.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);