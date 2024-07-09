<?php
function InsertarProveedor($MiConexion, $nombreProveedor, $cuil, $email, $telefono, $ciudad, $domicilio)
{
    // Escapar los datos para evitar SQL Injection
    $nombreProveedor = mysqli_real_escape_string($MiConexion, $nombreProveedor);
    $cuil = mysqli_real_escape_string($MiConexion, $cuil);
    $email = mysqli_real_escape_string($MiConexion, $email);
    $telefono = mysqli_real_escape_string($MiConexion, $telefono);
    $ciudad = mysqli_real_escape_string($MiConexion, $ciudad);
    $domicilio = mysqli_real_escape_string($MiConexion, $domicilio);

    // Iniciar una transacción para asegurar la integridad de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        // Insertar en la tabla domicilio
        $sqlDomicilio = "INSERT INTO domicilio (domicilio, idCiudad) VALUES ('$domicilio', '$ciudad')";
        if (!mysqli_query($MiConexion, $sqlDomicilio)) {
            throw new Exception("Error al insertar en la tabla domicilio: " . mysqli_error($MiConexion));
        }

        // Obtener el ID del domicilio recién insertado
        $idDomicilio = mysqli_insert_id($MiConexion);

        // Insertar en la tabla telefono
        $sqlTelefono = "INSERT INTO telefono (telefono) VALUES ('$telefono')";
        if (!mysqli_query($MiConexion, $sqlTelefono)) {
            throw new Exception("Error al insertar en la tabla telefono: " . mysqli_error($MiConexion));
        }

        // Obtener el ID del telefono recién insertado
        $idTelefono = mysqli_insert_id($MiConexion);



        // Insertar en la tabla email
        $sqlEmail = "INSERT INTO email (email) VALUES ('$email')";
        if (!mysqli_query($MiConexion, $sqlEmail)) {
            throw new Exception("Error al insertar en la tabla email: " . mysqli_error($MiConexion));
        }

        // Obtener el ID del telefono recién insertado
        $idEmail = mysqli_insert_id($MiConexion);




        // Insertar en la tabla proveedor
        $sqlProveedor = "INSERT INTO proveedor (nombreProveedor, cuil, idEmail, idDomicilio, idTelefono) VALUES ('$nombreProveedor', '$cuil', '$idEmail', '$idDomicilio', '$idTelefono')";
        if (!mysqli_query($MiConexion, $sqlProveedor)) {
            throw new Exception("Error al insertar en la tabla proveedor: " . mysqli_error($MiConexion));
        }

        // Confirmar la transacción
        mysqli_commit($MiConexion);

        return true;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        mysqli_rollback($MiConexion);

        // Devolver el mensaje de error
        return false;
    }
}
?>