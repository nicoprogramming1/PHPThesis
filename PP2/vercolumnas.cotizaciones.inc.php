<?php

$columnas = array(
    '#' => '#',
    'ID cotización' => 'ID cotización',
    'Nombre proveedor' => 'Nombre proveedor',
    'Fecha' => 'Fecha',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>