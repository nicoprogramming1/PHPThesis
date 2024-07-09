<?php
// Obtener la selección del menú desplegable
$seleccion = isset($_POST['eventos']) ? $_POST['eventos'] : '';
$contador = 1;

if ($seleccion === 'todos') {
    // Mostrar todas las órdenes de compra
    foreach ($ListadoOrdenCompra as $ordenCompra) {
        echo '<tr>';
        echo '<td>' . $contador++ . '</td>';
        echo '<td>' . $ordenCompra['IDORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenCompra['FECHAORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenCompra['ESTADOORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenCompra['PROVEEDORORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenCompra['FECHAMODIFICACION'] . '</td>';
        echo '<td>' . $ordenCompra['FECHAENVIO'] . '</td>';
        echo '</tr>';
    }
} elseif (!empty($seleccion)) {
    // Mostrar la orden de compra seleccionada
    $ordenSeleccionada = ObtenerOrdenCompraPorID($MiConexion, $seleccion);
    if ($ordenSeleccionada) {
        echo '<tr>';
        echo '<td>' . $contador++ . '</td>';
        echo '<td>' . $ordenSeleccionada['IDORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenSeleccionada['FECHAORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenSeleccionada['ESTADOORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenSeleccionada['PROVEEDORORDENCOMPRA'] . '</td>';
        echo '<td>' . $ordenSeleccionada['FECHAMODIFICACION'] . '</td>';
        echo '<td>' . $ordenSeleccionada['FECHAENVIO'] . '</td>';
        echo '</tr>';
    }
}
?>