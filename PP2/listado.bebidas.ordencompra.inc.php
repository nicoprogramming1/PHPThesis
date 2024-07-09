<?php
$contador = 1;

foreach ($ListadoBebidas as $bebida) {
    $idBebida = $bebida['idBebida'];
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $bebida['bebida'] . ' - ' . $bebida['marca'] . '</td>'; // Muestra el nombre de la bebida
    echo '<td><input type="text" name="cantidad_' . $idBebida . '" value="0"></td>'; // Muestra el cuadro de texto para la cantidad
    echo '</tr>';

    $contador++;
}
?>