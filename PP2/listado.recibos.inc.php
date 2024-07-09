<?php
$contador = 1;
foreach ($ListadoRecibos as $recibo) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $recibo['NRORECIBO'] . '</td>';
    echo '<td>' . $recibo['FECHARECIBO'] . '</td>';
    echo '<td>' . $recibo['IDCOMPRA'] . '</td>';
    echo '<td>' . $recibo['FECHACOMPRA'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $recibo['IDRECIBO'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>