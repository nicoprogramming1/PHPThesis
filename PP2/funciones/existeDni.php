<?php
function existeDni($conexion, $dniAsistente)
{
    $SQL = "SELECT idDni FROM dni WHERE dni = '$dniAsistente'";
    $resultado = mysqli_query($conexion, $SQL);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['idDni'];
    } else {
        return '';
    }
}
?>