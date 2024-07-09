<?php
// Función para eliminar un rol por su ID en la base de datos utilizando MySQLi
function eliminarRolPorID($conexion, $idRol)
{
    $consulta = "DELETE FROM roles WHERE idRol = ?";
    $query = $conexion->prepare($consulta);
    $query->bind_param('i', $idRol);
    
    if ($query->execute()) {
        return true; // Éxito al eliminar el rol
    } else {
        return false; // Error al eliminar el rol
    }
}
?>