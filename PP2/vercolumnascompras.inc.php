<?php

$columnas = array(
    '#' => '#',
    'Nro factura' => 'Nro factura',
    'Proveedor' => 'Proveedor',
    'Fecha de compra' => 'Fecha de compra',
    'Orden de compra' => 'Orden de compra',
    'Fecha de entrega prevista' => 'Fecha de entrega prevista',
    'Importe' => 'Importe',
    'Estado' => 'Estado',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>