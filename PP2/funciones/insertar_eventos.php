<?php
function InsertarEvento($conexion, $detalleEvento, $fechaEvento)
{
    // Escapar los datos para evitar inyección de SQL
    $detalleEvento = mysqli_real_escape_string($conexion, $detalleEvento);
    
    // Convertir la fecha al formato deseado
    $fechaEvento = DateTime::createFromFormat('d/m/y', $fechaEvento);
    $fechaEvento = $fechaEvento->format('Y-m-d');

    // Consulta SQL para insertar el evento en la tabla correspondiente
    $sql = "INSERT INTO evento (detalleEvento, fechaEvento) VALUES ('$detalleEvento', '$fechaEvento')";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        // Si la consulta se ejecuta con éxito, devolvemos true para indicar éxito
        return true;
    } else {
        // Si hubo un error en la consulta, puedes agregar algún registro de error o simplemente devolver false
        return false;
    }
}
?>