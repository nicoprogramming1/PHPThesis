<?php
$columnas = array(
    '#' => '#',
    'Bebida' => 'Bebida',
    'Cantidad' => 'Cantidad (*)',
    '' => ''
);

foreach ($columnas as $clave => $valor) {
    echo '<th>' . $valor . '</th>';
}
?>