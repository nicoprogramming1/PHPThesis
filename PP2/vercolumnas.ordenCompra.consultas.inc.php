<?php

$columnas = array(
    '#' => '#',
    'Id' => 'Id',
    'Fecha creación' => 'Fecha creación',
    'Estado' => 'Estado',
    'Proveedor' => 'Proveedor',
    'Fecha modificacion' => 'Fecha modificacion',
    'Fecha envío' => 'Fecha envío',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>