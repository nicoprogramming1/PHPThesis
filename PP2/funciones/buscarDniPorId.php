<?php
function ObtenerNumeroDniPorID($conexion, $idDni)
{
    $SQL = "SELECT dni FROM dni WHERE idDni = '$idDni'";
    $resultado = mysqli_query($conexion, $SQL);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['dni'];
    } else {
        return '';
    }
}
?>