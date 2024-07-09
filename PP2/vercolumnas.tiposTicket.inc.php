<?php

$columnas = array(
    '#' => '#',
    'Id' => 'Id',
    'Tipo' => 'Tipo',
    'Precio' => 'Precio',
    'Bebida 1' => 'Bebida1',
    'Bebida 2' => 'Bebida 2',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>