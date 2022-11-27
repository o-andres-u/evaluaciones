<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar la CP de la entidad
$identificadorEliminar = $_POST["identificador"];

// Query SQL a la BD
$query = "DELETE FROM pregunta WHERE identificador = '$identificadorEliminar'";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

if($result): 
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
    header ("Location: pregunta.php");
else:
    echo "Ha ocurrido un error al eliminar este registro";
endif;
 
mysqli_close($conn);