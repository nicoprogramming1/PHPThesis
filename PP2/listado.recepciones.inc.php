<?php
$contador = 1;
foreach ($ListadoRecepciones as $recepcion) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $recepcion['IDRECEPCIONCOMPRA'] . '</td>';
    echo '<td>' . $recepcion['NROREMITO'] . '</td>';
    echo '<td>' . $recepcion['FECHARECEPCIONCOMPRA'] . '</td>';
    echo '<td>' . $recepcion['ESTADORECEPCIONCOMPRA'] . '</td>';
    echo '<td>' . $recepcion['IDCOMPRA'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $recepcion['IDRECEPCIONCOMPRA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>