<?php

$columnas = array(
    '#' => '#',
    'Tipo' => 'Tipo',
    'Precio' => 'Precio',
    'Cantidad' => 'Cantidad',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>