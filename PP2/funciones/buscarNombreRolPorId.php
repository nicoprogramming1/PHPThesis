<?php
function buscarNombreRolPorID($conexion, $idRol)
{
    $consulta = "SELECT rol FROM roles WHERE idRol = ?";
    $query = $conexion->prepare($consulta);
    $query->bind_param('i', $idRol);
    $query->execute();
    $query->bind_result($nombreRol);
    $query->fetch();

    return $nombreRol;
}
?>