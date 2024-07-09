<?php

$columnas = array(
    '#' => '#',
    'Nro Recibo' => 'Nro Recibo',
    'FechaRecibo' => 'FechaRecibo',
    'idCompra' => 'idCompra',
    'FechaCompra' => 'FechaCompra',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>