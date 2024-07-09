<?php
function ObtenerListaOrdenesCompra($conexion) {
    $ordenCompra = array();
    $SQL = "SELECT oc.idOrdenCompra, oc.fechaEnvio, p.nombreProveedor
            FROM orden_compra oc, detalle_ordencompra do, estado_ordencompra eo, proveedor p
            WHERE oc.idOrdenCompra = do.idOrdenCompra AND eo.idEstadoOrdenCompra = oc.idEstadoOrdenCompra AND oc.idProveedor = p.idProveedor AND oc.idEstadoOrdenCompra = 1";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $ordenCompra[] = $fila;
    }
    return $ordenCompra;
}
?>