<?php
function ObtenerApellidoPromotorPorID($conexion, $idPromotor)
{
    // Aquí va tu código para obtener el apellido del promotor por su ID de la base de datos
    $sql = "SELECT apellido FROM promotores WHERE IDPROMOTORES = $idPromotor";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $promotor = $resultado->fetch_assoc();
        return $promotor['apellido'];
    } else {
        return null;
    }
}
?>