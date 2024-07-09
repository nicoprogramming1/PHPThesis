<?php

$columnas = array(
    '#' => '#',
    'Id' => 'Id',
    'Nombre' => 'Nombre',
    'Dni' => 'Dni',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>