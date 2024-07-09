<?php
$contador = 1;
foreach ($ListadoReclamos as $reclamo) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $reclamo['IDRECLAMO'] . '</td>';
    echo '<td>' . $reclamo['FECHARECLAMO'] . '</td>';
    echo '<td>' . $reclamo['ESTADORECLAMO'] . '</td>';
    echo '<td>' . $reclamo['IDRECEPCIONCOMPRA'] . '</td>';
    echo '<td>' . $reclamo['PROVEEDOR'] . '</td>';
    echo '<td>' . $reclamo['FECHACAMBIOESTADORECLAMO'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar" value="' . $reclamo['IDRECLAMO'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>