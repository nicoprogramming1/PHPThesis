<?php

require_once 'funciones/conexion.php';

function InsertarOrdenCompra($conexion, $proveedor) {
    // Inserta una nueva orden de compra y devuelve su ID

    // Define la consulta SQL
    $sql = "INSERT INTO orden_compra (idProveedor) VALUES (?)";

    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt === false) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Vincula los parámetros
    mysqli_stmt_bind_param($stmt, 'i', $proveedor);

    // Ejecuta la consulta
    if (mysqli_stmt_execute($stmt)) {
        // Devuelve el ID de la orden de compra recién insertada
        return mysqli_insert_id($conexion);
    } else {
        die('Error al insertar la orden de compra: ' . mysqli_error($conexion));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);
}

function InsertarDetalleOrdenCompra($conexion, $idOrdenCompra, $bebida, $cantidad) {
    // Inserta un detalle de orden de compra

    // Define la consulta SQL
    $sql = "INSERT INTO detalle_ordencompra (idOrdenCompra, idBebida, cantidadBebidas) VALUES (?, ?, ?)";

    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt === false) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Vincula los parámetros
    mysqli_stmt_bind_param($stmt, 'iii', $idOrdenCompra, $bebida, $cantidad);

    // Ejecuta la consulta
    if (!mysqli_stmt_execute($stmt)) {
        die('Error al insertar el detalle de orden de compra: ' . mysqli_error($conexion));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);
}

?>