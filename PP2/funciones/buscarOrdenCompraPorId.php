<?php
function ObtenerOrdenCompraPorID($conexion, $idOrdenCompra) {
    // Escapar el ID de la orden de compra para evitar SQL Injection
    $idOrdenCompra = (int) $idOrdenCompra;
    
    // Consulta para obtener los datos de la orden de compra
    $sql = "SELECT oc.idOrdenCompra, oc.fechaOrdenCompra, oc.fechaModificacion, oc.fechaEnvio, eo.detalleEstadoOrdenCompra, p.nombreProveedor
            FROM orden_compra oc, estado_ordencompra eo, proveedor p
            WHERE oc.idOrdenCompra = $idOrdenCompra AND oc.idProveedor = p.idProveedor AND eo.idEstadoOrdenCompra = oc.idEstadoOrdenCompra";
    
    $resultado = mysqli_query($conexion, $sql);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos de la orden de compra como un array asociativo
        $datosOrdenCompra = mysqli_fetch_assoc($resultado);
        
        // Liberar la memoria del resultado
        mysqli_free_result($resultado);
        
        return $datosOrdenCompra;
    } else {
        return false; // No se encontró la orden de compra con el ID especificado
    }
}
?>