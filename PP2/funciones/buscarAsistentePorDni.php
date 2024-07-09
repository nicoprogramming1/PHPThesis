<?php
function ObtenerAsistentePorDni($conexion, $dni)
{
    $dni = mysqli_real_escape_string($conexion, $dni);
    $sql = "SELECT idAsistentes FROM asistentes WHERE idDni IN (SELECT idDni FROM dni WHERE dni = '$dni')";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['idAsistentes'];
    }

    return null;
}
?>