<?php

$columnas = array(
    '#' => '#',
    'Id' => 'Id',
    'Cajero' => 'Cajero',
    'Fecha' => 'Fecha',
    'Hora' => 'Hora',
    'Estado' => 'Estado',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>