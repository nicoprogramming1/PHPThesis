<?php
function ObtenerCantidadPredeterminada($conexion, $idBebida, $idOrdenCompra) {
    $sql = "SELECT cantidadBebidas FROM detalle_ordencompra WHERE idBebida = $idBebida AND idOrdenCompra = $idOrdenCompra";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        return $row['cantidadBebidas'];
    } else {
        return 0; // Valor por defecto si no se encuentra en la base de datos
    }
}

function ObtenerCantidadPredeterminadaParaModificarRecepcionCompra($conexion, $idBebida, $idCompra) {
    $sql = "SELECT d.cantidadBebidas
            FROM detalle_ordencompra d, orden_compra o, detalle_compra c
            WHERE d.idBebida = $idBebida AND o.idOrdenCompra = c.idOrdenCompra AND c.idCompra = $idCompra";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        return $row['cantidadBebidas'];
    } else {
        return 0; // Valor por defecto si no se encuentra en la base de datos
    }
}
?>