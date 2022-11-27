<?php

// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD
$query = "SELECT * FROM conocimiento_evaluado";

// Ejecutar la consulta
$resultadoConocimiento_evaluado = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);