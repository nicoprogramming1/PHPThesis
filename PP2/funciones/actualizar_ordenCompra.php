<?php
// Función para actualizar el proveedor de la orden de compra y la fecha de modificación
function ActualizarProveedorOrdenCompra($conexion, $idOrdenCompra, $nuevoProveedor) {
    $sql = "UPDATE orden_compra SET idProveedor = $nuevoProveedor, fechaModificacion = CURRENT_TIMESTAMP WHERE idOrdenCompra = $idOrdenCompra";
    return mysqli_query($conexion, $sql);
}

// Función para actualizar la cantidad de una bebida
function ActualizarCantidadBebida($conexion, $idOrdenCompra, $idBebida, $nuevaCantidad) {
    // Verificar si existe una entrada en la tabla detalle_ordencompra para esta bebida y orden de compra
    $consulta = "SELECT COUNT(*) AS count FROM detalle_ordencompra WHERE idOrdenCompra = $idOrdenCompra AND idBebida = $idBebida";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila['count'] > 0) {
        // Si la entrada existe, actualizar la cantidad
        $sql = "UPDATE detalle_ordencompra SET cantidadBebidas = $nuevaCantidad WHERE idOrdenCompra = $idOrdenCompra AND idBebida = $idBebida";
    } else {
        // Si la entrada no existe, insertar una nueva
        $sql = "INSERT INTO detalle_ordencompra (idOrdenCompra, idBebida, cantidadBebidas) VALUES ($idOrdenCompra, $idBebida, $nuevaCantidad)";
    }

    return mysqli_query($conexion, $sql);
}

// Función para eliminar una entrada en detalle_ordencompra
function EliminarDetalleOrdenCompra($conexion, $idOrdenCompra, $idBebida) {
    // Verificar si existe una entrada en la tabla detalle_ordencompra para esta bebida y orden de compra
    $consulta = "SELECT COUNT(*) AS count FROM detalle_ordencompra WHERE idOrdenCompra = $idOrdenCompra AND idBebida = $idBebida";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila['count'] > 0) {
        // Si la entrada existe, eliminarla
        $sql = "DELETE FROM detalle_ordencompra WHERE idOrdenCompra = $idOrdenCompra AND idBebida = $idBebida";
        return mysqli_query($conexion, $sql);
    }

    return true; // No se encontró la entrada, no es necesario eliminar nada.
}
?>