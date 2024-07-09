<?php
function ObtenerAsistentePorID($conexion, $idAsistente)
{
    // Escapar el ID del asistente para evitar SQL Injection
    $idAsistente = (int) $idAsistente;

    // Consulta para obtener los datos del asistente por su ID, incluyendo el número de DNI
    $sql = "SELECT a.*, d.dni FROM asistentes a
            JOIN dni d ON a.idDni = d.idDni
            WHERE a.IDASISTENTES = $idAsistente";

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del asistente como un array asociativo
        $datosAsistente = mysqli_fetch_assoc($resultado);

        // Liberar la memoria del resultado
        mysqli_free_result($resultado);

        return $datosAsistente;
    } else {
        return false; // No se encontró el asistente con el ID especificado
    }
}
?>