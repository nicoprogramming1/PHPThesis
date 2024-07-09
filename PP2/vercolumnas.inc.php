<?php

$columnas = array(
    '#' => '#',
    'ID' => 'ID',
    'Email' => 'Email',
    'Nombre' => 'Nombre',
    'Apellido' => 'Apellido',
    'Rol' => 'Rol',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>