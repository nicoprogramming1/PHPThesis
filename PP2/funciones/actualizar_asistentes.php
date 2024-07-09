<?php
function ObtenerIdDni($conexion, $dni)
{
    $dni = mysqli_real_escape_string($conexion, $dni);

    // Verificar si el DNI ya existe en la tabla dni
    $SQL_Select_Dni = "SELECT idDni FROM dni WHERE dni = '$dni'";
    $resultado = mysqli_query($conexion, $SQL_Select_Dni);

    if (mysqli_num_rows($resultado) > 0) {
        // El DNI ya existe, devolver su ID
        $row = mysqli_fetch_assoc($resultado);
        return $row['idDni'];
    } else {
        // El DNI no existe, insertarlo y devolver el ID generado
        $SQL_Insert_Dni = "INSERT INTO dni (dni) VALUES ('$dni')";
        if (mysqli_query($conexion, $SQL_Insert_Dni)) {
            return mysqli_insert_id($conexion);
        } else {
            return null; // Error al insertar el DNI
        }
    }
}

function ModificarAsistentes($conexion, $idAsistente, $nuevoNombre, $nuevoDni)
{
    // Sanitizar los datos para evitar ataques de inyección SQL
    $idAsistente = mysqli_real_escape_string($conexion, $idAsistente);
    $nuevoNombre = mysqli_real_escape_string($conexion, $nuevoNombre);
    $nuevoDni = mysqli_real_escape_string($conexion, $nuevoDni);

    // Obtener el ID del DNI o insertar uno nuevo si no existe
    $idDni = ObtenerIdDni($conexion, $nuevoDni);
    if ($idDni === null) {
        return false; // Error al obtener o insertar el DNI
    }

    // Consulta para actualizar el nombre, DNI y promotor referido del asistente en la base de datos
    $SQL_Update_Asistente = "UPDATE asistentes SET nombre = '$nuevoNombre', idDni = '$idDni' WHERE idAsistentes = '$idAsistente'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Update_Asistente)) {
        return true; // Modificación exitosa
    } else {
        return false; // Error al modificar el asistente
    }
}
?>