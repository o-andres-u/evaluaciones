<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Entidad análoga a PELICULA (pregunta)</h1>

<!-- FORMULARIO -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="pregunta_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="identificador" class="form-label">Identificador</label>
            <input type="text" class="form-control" id="identificador" name="identificador" required>
        </div>

        <div class="mb-3">
            <label for="enunciado " class="form-label">Enunciado</label>
            <input type="text" class="form-control" id="enunciado" name="enunciado" required>
        </div>

        <div class="mb-3">
            <label for="anio_creacion" class="form-label">Año de creación</label>
            <input type="number" class="form-control" id="anio_creacion" name="anio_creacion" required>
        </div>

        <div class="mb-3">
            <label for="nivel_dificultad" class="form-label">Nivel de dificultad</label>
            <select name="nivel_dificultad" id="nivel_dificultad" class="form-select" require>
                <option value="" selected disabled hidden></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        
        <!-- Consultar la lista de preguntas y desplegarlos -->
        <div class="mb-3">
            <label for="pregunta_madre" class="form-label">Pregunta madre</label>
            <select name="pregunta_madre" id="pregunta_madre" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../pregunta/pregunta_select.php");
                
                // Verificar si llegan datos
                if($resultadoPregunta):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoPregunta as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["identificador"]; ?>"><?= $fila["enunciado"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("pregunta_select.php");

// Verificar si llegan datos
if($resultadoPregunta and $resultadoPregunta->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Id</th>
                <th scope="col" class="text-center">Enunciado</th>
                <th scope="col" class="text-center">Año de creación</th>
                <th scope="col" class="text-center">Dificultad</th>
                <th scope="col" class="text-center">Pregunta madre</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoPregunta as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["identificador"]; ?></td>
                <td class="text-center"><?= $fila["enunciado"]; ?></td>
                <td class="text-center"><?= $fila["anio_creacion"]; ?></td>
                <td class="text-center"><?= $fila["nivel_dificultad"]; ?></td>
                <td class="text-center"><?= $fila["pregunta_madre"]; ?></td>
                
                <!-- Botón de eliminar. -->
                <td class="text-center">
                    <form action="pregunta_delete.php" method="post">
                        <input hidden type="text" name="identificador" value="<?= $fila["identificador"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>