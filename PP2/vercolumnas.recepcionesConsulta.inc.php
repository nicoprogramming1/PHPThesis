<?php

$columnas = array(
    '#' => '#',
    'ID recepción' => 'ID recepción',
    'Fecha' => 'Fecha',
    'Estado' => 'Estado',
    'ID compra' => 'ID compra',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>