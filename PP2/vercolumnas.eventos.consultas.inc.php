<?php

$columnas = array(
    '#' => '#',
    'ID' => 'ID',
    'Detalle Evento' => 'Detalle Evento',
    'Fecha Evento' => 'Fecha Evento',
    'Asistentes' => 'Asistentes',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>