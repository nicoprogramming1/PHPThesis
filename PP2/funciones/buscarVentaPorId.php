<?php
function ObtenerVentaPorId($conexion, $idVenta)
{
    $query = "SELECT * FROM venta WHERE idVenta = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la venta
    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result); // Devolver los datos de la venta como un arreglo asociativo
    } else {
        return null; // No se encontró la venta o hubo un error en la consulta
    }
}
?>