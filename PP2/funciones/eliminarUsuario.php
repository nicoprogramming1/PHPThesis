<?php
function eliminarUsuario($conexion, $idUsuario)
{
    // Consulta SQL para eliminar el usuario por su ID
    $consulta = "DELETE FROM usuarios WHERE idUsuario = ?";
    $query = $conexion->prepare($consulta);
    $query->bind_param('i', $idUsuario);

    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($query->execute()) {
        return true;
    } else {
        return false;
    }
}
?>