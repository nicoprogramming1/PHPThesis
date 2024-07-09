<?php

$columnas = array(
    '#' => '#',
    'ID' => 'ID',
    'Cajero' => 'Cajero',
    'Fecha Evento' => 'Fecha Evento',
    'Monto' => 'Monto',
    'Evento' => 'Evento',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>