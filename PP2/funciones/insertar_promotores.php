<?php
function InsertarPromotor($conexion, $nombre, $apellido) {
    // Sanitizar los datos antes de insertarlos en la base de datos (para evitar SQL Injection)
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellido = mysqli_real_escape_string($conexion, $apellido);

    // Consulta para insertar el nuevo promotor
    $consulta = "INSERT INTO promotores (nombre, apellido) VALUES ('$nombre', '$apellido')";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $consulta)) {
        return true; // Registro exitoso
    } else {
        return false; // Error al insertar el registro
    }
}
?>