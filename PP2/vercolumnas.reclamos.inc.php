<?php

$columnas = array(
    '#' => '#',
    'ID reclamo' => 'ID reclamo',
    'Fecha de reclamo' => 'Fecha de reclamo',
    'Estado reclamo' => 'Estado reclamo',
    'ID recepción de compra' => 'ID recepción de compra',
    'Proveedor' => 'Proveedor',
    'Fecha de cambio de estado' => 'Fecha de cambio de estado',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>