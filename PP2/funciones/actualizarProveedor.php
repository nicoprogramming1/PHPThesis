<?php 
function actualizarProveedor($MiConexion, $idProveedorAModificar, $nombreProveedor, $cuil, $email, $idEmail, $telefono, $idTelefono, $domicilio, $idDomicilio, $idCiudad) {

    // Sanitiza y verifica los datos para evitar SQL injection
    $idProveedorAModificar = mysqli_real_escape_string($MiConexion, $idProveedorAModificar);
    $nombreProveedor = mysqli_real_escape_string($MiConexion, $nombreProveedor);
    $cuil = mysqli_real_escape_string($MiConexion, $cuil);
    $email = mysqli_real_escape_string($MiConexion, $email);
    $telefono = mysqli_real_escape_string($MiConexion, $telefono);
    $domicilio = mysqli_real_escape_string($MiConexion, $domicilio);
    $idCiudad = mysqli_real_escape_string($MiConexion, $idCiudad);

    // Consulta SQL para actualizar el proveedor
    $SQL = "UPDATE proveedor SET 
            nombreProveedor = '$nombreProveedor', 
            cuil = '$cuil'
            WHERE idProveedor = '$idProveedorAModificar'";

    $resultado = mysqli_query($MiConexion, $SQL);

    $SQL1 = "UPDATE email SET 
            email = '$email'
            WHERE idEmail = '$idEmail'";

    $resultado1 = mysqli_query($MiConexion, $SQL1);

    $SQL2 = "UPDATE domicilio SET 
            domicilio = '$domicilio',
            idCiudad = '$idCiudad'
            WHERE idDomicilio = '$idDomicilio'";

    $resultado2 = mysqli_query($MiConexion, $SQL2);

    $SQL3 = "UPDATE telefono SET 
            telefono = '$telefono' 
            WHERE idTelefono = '$idTelefono'";

    $resultado3 = mysqli_query($MiConexion, $SQL3);

    return $resultado && $resultado1 && $resultado2 && $resultado3;
}
?>
