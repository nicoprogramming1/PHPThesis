<?php

$columnas = array(
    '#' => '#',
    'ID bebida' => 'ID bebida',
    'Bebida' => 'Bebida',
    'Marca' => 'Marca',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>