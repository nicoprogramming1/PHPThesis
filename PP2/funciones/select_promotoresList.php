<?php
function ObtenerListaPromotores($conexion)
{
    $promotoresReferidosList = array();
    $SQL = "SELECT idPromotores, nombre, apellido FROM promotores";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $promotoresReferidosList[] = $fila;
    }
    return $promotoresReferidosList;
}
?>