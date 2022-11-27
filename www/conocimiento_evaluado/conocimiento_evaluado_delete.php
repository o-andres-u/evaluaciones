<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar la CP de la entidad
$tema_evaluadoEliminar = $_POST["tema_evaluadoEliminar"];
$pregunta_asignadaEliminar = $_POST["pregunta_asignadaEliminar"];
// Query SQL a la BD
$query = "DELETE FROM conocimiento_evaluado WHERE tema_evaluado = '$tema_evaluadoEliminar' and pregunta_asignada  = '$pregunta_asignadaEliminar'";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

if($result): 
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
    header ("Location: conocimiento_evaluado.php");
else:
    echo "Ha ocurrido un error al eliminar este registro";
endif;
 
mysqli_close($conn);