<?php
function EliminarOrdenCompraYDetalles($conexion, $idOrdenCompra) {
    // Eliminar detalles de la orden de compra en la tabla detalle_ordencompra
    $sql = "DELETE FROM detalle_ordencompra WHERE idOrdenCompra = $idOrdenCompra";
    if (mysqli_query($conexion, $sql)) {
        // Después de eliminar los detalles, elimina la orden de compra en la tabla orden_compra
        $sql = "DELETE FROM orden_compra WHERE idOrdenCompra = $idOrdenCompra";
        return mysqli_query($conexion, $sql);
    } else {
        return false;
    }
}
?>