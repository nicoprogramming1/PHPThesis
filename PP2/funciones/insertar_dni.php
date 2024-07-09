<?php
function InsertarDni($conexion, $dni)
{
    // Escapar el DNI para evitar SQL Injection
    $dni = mysqli_real_escape_string($conexion, $dni);

    $sql = "INSERT INTO dni (dni) VALUES ('$dni')";
    if (mysqli_query($conexion, $sql)) {
        return mysqli_insert_id($conexion); // Devolver el ID del DNI insertado
    } else {
        return false; // Hubo un error al insertar el DNI
    }
    }
?>