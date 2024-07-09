<?php 
function ActualizarEvento($conexion, $idEvento, $fechaEvento, $nuevoDetalle)
{
    // Escapar los datos para evitar inyección de SQL
    $nuevoDetalle = mysqli_real_escape_string($conexion, $nuevoDetalle);

    // Convertir la fecha al formato deseado
    $fechaEvento = DateTime::createFromFormat('d/m/y', $fechaEvento);
    $fechaEvento = $fechaEvento->format('Y-m-d');

    $query = "UPDATE evento SET fechaEvento = ?, detalleEvento = ? WHERE idEvento = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssi', $fechaEvento, $nuevoDetalle, $idEvento);
    return $stmt->execute();
}
?>