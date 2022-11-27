<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Consulta 2</h1>

<p class="mt-3">
Debe mostrar el identificador y el titulo de cada uno de los temas
que cumplen todas las siguientes condiciones: tienen al menos tres tema_evaluado y
la sumatoria de sus pesos (de sus conocimiento_evalaudo) es mayor que 50.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD 
$query = "SELECT t.identificador, t.titulo
FROM tema t
WHERE t.identificador IN (
    SELECT ce.tema_evaluado
    FROM conocimiento_evaluado ce
    GROUP BY ce.tema_evaluado
    HAVING COUNT(ce.tema_evaluado) >= 3 AND SUM(ce.peso) > 50
);";

// Ejecutar la consulta
$resultadoC2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC2 and $resultadoC2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Titulo</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["titulo"]; ?></td>
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
else:
?>

<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>

<?php
endif;

include "../includes/footer.php";
?>