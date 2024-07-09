<?php

$columnas = array(
    'ID proveedor' => 'ID proveedor',
    'Nombre proveedor' => 'Nombre proveedor',
    'Concurrencia' => 'Concurrencia',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>