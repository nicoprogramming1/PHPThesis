<?php

$columnas = array(
    '#' => '#',
    'ID' => 'ID',
    'Detalle Evento' => 'Detalle Evento',
    'Fecha Evento' => 'Fecha Evento',
    'Ventas' => 'Ventas',
    'Ganancia' => 'Ganancia',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>