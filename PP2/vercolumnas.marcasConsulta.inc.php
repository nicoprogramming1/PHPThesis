<?php

$columnas = array(
    '#' => '#',
    'ID marca' => 'ID marca',
    'Marca' => 'Marca',
    '' => ''
);

    foreach ($columnas as $clave => $valor) {
        echo '<th>' . $valor . '</th>';
    }
?>