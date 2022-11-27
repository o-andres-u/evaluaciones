<?php
include "../includes/header.php";
?>


<h1 class="mt-3">Entidad análoga a ROL (conocimiento_evaluado)</h1>

<!-- FORMULARIO. -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="conocimiento_evaluado_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="tema_evaluado" class="form-label">Tema evaluado</label>
            <select name="tema_evaluado" id="tema_evaluado" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../tema/tema_select.php");
                
                // Verificar si llegan datos
                if($resultadoTema):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoTema as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["identificador"]; ?>"><?= $fila["titulo"]; ?>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="pregunta_asignada" class="form-label">Pregunta asignada</label>
            <select name="pregunta_asignada" id="pregunta_asignada" class="form-select">
                
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
                <option value="<?= $fila["identificador"]; ?>"><?= $fila["enunciado"]; ?>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="peso " class="form-label">Peso</label>
            <input type="number" class="form-control" id="peso" name="peso" required>
        </div>


        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("conocimiento_evaluado_select.php");
            
// Verificar si llegan datos
if($resultadoConocimiento_evaluado and $resultadoConocimiento_evaluado->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Tema</th>
                <th scope="col" class="text-center">Pregunta</th>
                <th scope="col" class="text-center">Peso</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoConocimiento_evaluado as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["tema_evaluado"]; ?></td>
                <td class="text-center"><?= $fila["pregunta_asignada"]; ?></td>
                <td class="text-center"><?= $fila["peso"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="conocimiento_evaluado_delete.php" method="post">
                        <input hidden type="text" name="tema_evaluadoEliminar" value="<?= $fila["tema_evaluado"]; ?>">
                        <input hidden type="text" name="pregunta_asignadaEliminar" value="<?= $fila["pregunta_asignada"]; ?>">
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