<?php
function ObtenerNumerosDniExistentes($conexion)
{
    $dniExistenteList = array();
    $SQL = "SELECT idDni, dni FROM dni";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $dniExistenteList[] = $fila;
    }
    return $dniExistenteList;
}
?>