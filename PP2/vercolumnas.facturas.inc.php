<?php

$columnas = array(
    '#' => '#',
    'Nro factura' => 'Nro factura',
    'Proveedor' => 'Proveedor',
    'Fecha' => 'Fecha',
    'Importe' => 'Importe',
    'Estado' => 'Estado',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>