<?php

$columnas = array(
    '#' => '#',
    'ID bebida' => 'ID bebida',
    'Bebida' => 'Bebida',
    'Marca' => 'Marca',
    'Volumen' => 'Volumen',
    'Stock (unidades)' => 'Stock (unidades)',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>