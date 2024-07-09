<?php
$contador = 1;
foreach ($ListadoUsuarios as $usuario) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $usuario['ID'] . '</td>';
    echo '<td>' . $usuario['EMAIL'] . '</td>';
    echo '<td>' . $usuario['NOMBRE'] . '</td>';
    echo '<td>' . $usuario['APELLIDO'] . '</td>';
    echo '<td>' . $usuario['ROL'] . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $usuario['ID'] . '"></td>';
    echo '</tr>';
    $contador++;
}