<?php
function EliminarAsistente($conexion, $idAsistente)
{
    $idAsistente = mysqli_real_escape_string($conexion, $idAsistente);

    // Consulta para eliminar el asistente de la base de datos
    $SQL_Delete_Asistente = "DELETE FROM asistentes WHERE idAsistentes = '$idAsistente'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Delete_Asistente)) {
        return true; // Eliminación exitosa
    } else {
        return false; // Error al eliminar el asistente
    }
}
?>