<?php

$columnas = array(
    '#' => '#',
    'ID recepción' => 'ID recepción',
    'Nro remito' => 'Nro remito',
    'Fecha de recepción' => 'Fecha de recepción',
    'Estado recepción' => 'Estado recepción',
    'ID compra' => 'ID compra',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>