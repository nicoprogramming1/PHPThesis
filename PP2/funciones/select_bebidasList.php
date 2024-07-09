<?php
function ObtenerListaBebidas($conexion)
{
    $bebida = array();
    $SQL = "SELECT b.idBebida, b.bebida, m.marca FROM bebida b INNER JOIN marca m ON b.idMarca = m.idMarca";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $bebida[] = $fila;
    }
    return $bebida;
}
?>