<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Búsqueda 2</h1>

<p class="mt-3">
El identificador de una pregunta. Se debe mostrar todo lo siguiente para la pregunta correspondiente al identificador ingresado.
<ul>
    <li>Su enunciado y su año de creación.</li>
    <li>El identificador y enunciado de su pregunta madre (si la tiene).</li>
    <li>El identificador y enunciado de todas sus preguntas hijas (solamente las preguntas directas, es decir, no incluya las preguntas de preguntas…) que tiene.</li>
</ul>


</p>


<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda2.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="identificador" class="form-label">Codigo Pregunta</label>
            <input type="text" class="form-control" id="identificador" name="identificador" required>
        </div>


        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer esta verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    $identificador = $_POST["identificador"];
   

    // Query SQL a la BD 
    $query = "SELECT p.identificador, p.enunciado as enunciado, p.anio_creacion, p.pregunta_madre, madre.enunciado as menunciado
    FROM pregunta p
    LEFT JOIN pregunta madre
    ON p.pregunta_madre = madre.identificador
    WHERE p.identificador = '$identificador';";

    // Ejecutar la consulta
    $resultadoB2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB2 and $resultadoB2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Enunciado</th>
                <th scope="col" class="text-center">Año de creación</th>
             

            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["enunciado"]; ?></td>
                <td class="text-center"><?= $fila["anio_creacion"]; ?></td>
                
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php if($fila["pregunta_madre"]):?>
    <br>
    <br>
    <h3>Información de la madre</h3>
    <div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Identificador</th>
                <th scope="col" class="text-center">Enunciado</th>
            

            </tr>
        </thead>

        <tbody>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["pregunta_madre"] ?></td>
                <td class="text-center"><?= $fila["menunciado"] ?></td>
                
            </tr>

        </tbody>

    </table>
    </div>

<?php
    require('../config/conexion.php');

    $query = "SELECT p.identificador, p.enunciado
    FROM pregunta p
    WHERE p.pregunta_madre = '$identificador';";

    // Ejecutar la consulta
    $resultadoB3 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB3 and $resultadoB3->num_rows > 0):

?>
<br>
<br>
<h3>Preguntas hijas</h3>
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

<table class="table table-striped table-bordered">

    <!-- Títulos de la tabla. -->
    <thead class="table-dark">
        <tr>
            <th scope="col" class="text-center">Enunciado</th>
            <th scope="col" class="text-center">Año de creación</th>
         

        </tr>
    </thead>

    <tbody>

        <?php
        // Iterar sobre los registros que llegaron
        foreach ($resultadoB3 as $fila):
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

<?php endif;
endif;?>

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