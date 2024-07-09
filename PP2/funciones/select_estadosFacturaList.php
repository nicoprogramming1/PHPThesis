<?php
function ObtenerListaEstadosFactura($conexion) {
    $estadoFactura = array();
    $SQL = "SELECT estadoFactura, idEstadoFactura FROM estado_factura";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $estadoFactura[] = $fila;
    }
    return $estadoFactura;
}
?>