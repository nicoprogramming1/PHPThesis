<?php
require_once 'funciones/conexion.php';

function CambiarEstadoOrdenCompra($conexion, $ordenCompraSeleccionada, $nuevoEstado) {
    // Asegúrate de que $ordenCompraSeleccionada sea un array
    if (!is_array($ordenCompraSeleccionada)) {
        $ordenCompraSeleccionada = [$ordenCompraSeleccionada];
    }

    // Escapa y formatea los IDs de orden de compra para la consulta
    $escapedIDs = array_map(function ($id) use ($conexion) {
        return mysqli_real_escape_string($conexion, $id);
    }, $ordenCompraSeleccionada);

    // Convierte los IDs en una cadena separada por comas
    $formattedIDs = implode(',', $escapedIDs);

    // Obtén la fecha y hora actual
    $fechaEnvio = date('Y-m-d H:i:s');

    // Actualiza el estado y la fecha de envío en la tabla orden_compra
    $sql = "UPDATE orden_compra SET idEstadoOrdenCompra = $nuevoEstado, fechaEnvio = '$fechaEnvio' WHERE idOrdenCompra IN ($formattedIDs)";

    return mysqli_query($conexion, $sql);
}
?>