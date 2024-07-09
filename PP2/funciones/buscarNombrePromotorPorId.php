<?php
function ObtenerNombrePromotorPorID($conexion, $idPromotor)
{
    // Aquí va tu código para obtener el nombre del promotor por su ID de la base de datos
    $sql = "SELECT nombre FROM promotores WHERE IDPROMOTORES = $idPromotor";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $promotor = $resultado->fetch_assoc();
        return $promotor['nombre'];
    } else {
        return null;
    }
}
?>