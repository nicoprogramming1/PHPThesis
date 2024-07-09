<?php
$contador = 1;
foreach ($ListadoPromotores as $promotor) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $promotor['IDPROMOTORES'] . '</td>';
    echo '<td>' . $promotor['NOMBRE'] . '</td>';
    echo '<td>' . $promotor['APELLIDO'] . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $promotor['IDPROMOTORES'] . '"></td>';
    echo '</tr>';
    $contador++;
}