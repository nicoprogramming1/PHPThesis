<?php 
function actualizarCompra($conexion, $idCompra, $fechaEntregaPrevista, $detalleCompra, $idOrdenCompra, $factura) {
    // Evitar inyecciones SQL usando sentencias preparadas
    $sql = "UPDATE compra c, detalle_compra dc SET c.fechaEntregaPrevista = ?, dc.detalleCompra = ?, dc.idOrdenCompra = ?, dc.idFactura = ? WHERE c.idCompra = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("sssii", $fechaEntregaPrevista, $detalleCompra, $idOrdenCompra, $factura, $idCompra);

        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Compra actualizada con éxito
        } else {
            $stmt->close();
            return false; // Error al actualizar la compra
        }
    } else {
        return false; // Error en la sentencia preparada
    }
}
?>