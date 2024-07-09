<?php

$columnas = array(
    '#' => '#',
    'ID reclamo' => 'ID reclamo',
    'Fecha de reclamo' => 'Fecha de reclamo',
    'Fecha de cambio de estado' => 'Fecha de cambio de estado',
    'Estado' => 'Estado',
    'Detalle' => 'Detalle',
    'Proveedor' => 'Proveedor',
    'ID recepción de compra' => 'ID recepción de compra',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>