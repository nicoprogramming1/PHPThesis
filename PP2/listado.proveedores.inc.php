<?php
$contador = 1;
foreach ($ListadoProveedores as $proveedor) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $proveedor['IDPROVEEDOR'] . '</td>';
    echo '<td>' . $proveedor['NOMBREPROVEEDOR'] . '</td>';
    echo '<td>' . $proveedor['CUIL'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $proveedor['IDPROVEEDOR'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>