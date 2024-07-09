<?php

$columnas = array(
    '#' => '#',
    'ID' => 'ID',
    'Nombre' => 'Nombre',
    'Apellido' => 'Apellido',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>