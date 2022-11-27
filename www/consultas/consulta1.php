<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Consulta 1</h1>

<p class="mt-3">
    Debe mostrar el identificador y el enunciado de cada una de las preguntas
    que cumplen todas las siguientes condiciones: su nivel de dificultad  mayor que 2, tiene
    al menos dos preguntas asignadas y su año de creacion fue mayor que 2020.
</p>




<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD 
$query = "SELECT p.identificador, p.enunciado
FROM pregunta p
WHERE p.identificador IN (
    SELECT ce.pregunta_asignada 
    FROM conocimiento_evaluado ce
    GROUP BY ce.pregunta_asignada
    HAVING COUNT(ce.pregunta_asignada) >= 2
)
AND p.nivel_dificultad > 2
AND p.anio_creacion > 2020;";

// Ejecutar la consulta
$resultadoC1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC1 and $resultadoC1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Enunciado</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["enunciado"]; ?></td>
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