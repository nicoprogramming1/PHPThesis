<?php

$columnas = array(
    '#' => '#',
    'Asistente' => 'Asistente',
    'DNI' => 'DNI',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>