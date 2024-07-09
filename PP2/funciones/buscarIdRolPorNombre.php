<?php
// Función para buscar el ID de un rol por su nombre en la base de datos (utilizando mysqli)
function buscarIdRolPorNombre($conexion, $nombreRol)
{
    $consulta = "SELECT idRol FROM roles WHERE rol = ?";
    $query = $conexion->prepare($consulta);
    $query->bind_param('s', $nombreRol);
    $query->execute();

    // Obtener el resultado de la consulta
    $query->bind_result($idRol);
    $query->fetch();

    return $idRol;
}
?>