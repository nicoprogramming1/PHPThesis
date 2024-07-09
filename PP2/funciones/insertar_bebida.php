<?php
function InsertarBebida($MiConexion, $bebida, $marca, $volumen)
{
    // Preparar la consulta con marcadores de posición (?)
    $query = "INSERT INTO bebida (bebida, idMarca, idVolumen) VALUES (?, ?, ?)";
    
    // Preparar la declaración
    $stmt = mysqli_prepare($MiConexion, $query);

    if ($stmt) {
        // Vincular parámetros a la consulta preparada como cadenas de texto
        mysqli_stmt_bind_param($stmt, 'sii', $bebida, $marca, $volumen);

        // Ejecutar la consulta preparada
        $resultado = mysqli_stmt_execute($stmt);

        // Verificar si la ejecución fue exitosa
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>