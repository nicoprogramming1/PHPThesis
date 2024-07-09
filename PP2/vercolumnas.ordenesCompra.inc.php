<?php

$columnas = array(
    '#' => '#',
    'Id' => 'Id',
    'Fecha' => 'Fecha',
    'Estado' => 'Estado',
    'Proveedor' => 'Proveedor',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>