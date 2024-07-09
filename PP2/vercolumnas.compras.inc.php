<?php

$columnas = array(
    '#' => '#',
    'ID compra' => 'ID compra',
    'Nro factura' => 'Nro factura',
    'Proveedor' => 'Proveedor',
    'Fecha de compra' => 'Fecha de compra',
    'Fecha de entrega prevista' => 'Fecha de entrega prevista',
    'Importe' => 'Importe',
    'Estado compra' => 'Estado compra',
    'ID orden compra' => 'ID orden compra',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>