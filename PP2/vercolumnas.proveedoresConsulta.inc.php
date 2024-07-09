<?php

$columnas = array(
    '#' => '#',
    'ID proveedor' => 'ID proveedor',
    'Nombre proveedor' => 'Nombre proveedor',
    'CUIL' => 'CUIL',
    'Domicilio' => 'Domicilio',
    'Telefono' => 'Telefono',
    'Email' => 'Email',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>