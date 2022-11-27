<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Búsqueda 1</h1>

<p class="mt-3">
    Dos años: a1 y a2, a1 < a2. Se debe mostrar todas las preguntas cuyo año de
    creacion > a1 y año de creacion < a2.
</p>

<!-- FORMULARIO. -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda1.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="anio_1" class="form-label">Año 1</label>
            <input type="number" class="form-control" id="anio_1" name="anio_1" required>
        </div>

        <div class="mb-3">
            <label for="anio_2" class="form-label">Año 2</label>
            <input type="number" class="form-control" id="anio_2" name="anio_2" required>
        </div>


        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer esta verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    $anio_1 = $_POST["anio_1"];
    $anio_2 = $_POST["anio_2"];

    // Query SQL a la BD 
    $query = "SELECT p.identificador, p.enunciado
    FROM pregunta p
    WHERE p.anio_creacion > '$anio_1' AND p.anio_creacion < '$anio_2';";

    // Ejecutar la consulta
    $resultadoB1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB1 and $resultadoB1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA.  -->
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
            foreach ($resultadoB1 as $fila):
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
endif;

include "../includes/footer.php";
?>