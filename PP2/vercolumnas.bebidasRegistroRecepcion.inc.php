<?php

$columnas = array(
    'ID bebida' => 'ID bebida',
    'Bebida' => 'Bebida',
    'Marca' => 'Marca',
    'Volumen' => 'Volumen',
    'Cantidad' => 'Cantidad',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>