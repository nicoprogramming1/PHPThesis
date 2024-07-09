<?php

$columnas = array(
    '#' => '#',
    'ID proveedor' => 'ID proveedor',
    'Nombre proveedor' => 'Nombre proveedor',
    'CUIL' => 'CUIL',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>