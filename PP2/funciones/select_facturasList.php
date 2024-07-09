<?php
function ObtenerListaFacturas($conexion) {
    $factura = array();
    $SQL = "SELECT f.idFactura, f.nroFactura, f.fechaFactura, p.nombreProveedor
            FROM factura f, estado_factura e, proveedor p, detalle_factura d
            WHERE f.idEstadoFactura = e.idEstadoFactura AND f.idEstadoFactura = 2 AND f.idFactura = d.idFactura AND d.idProveedor = p.idProveedor";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $factura[] = $fila;
    }
    return $factura;
}
?>