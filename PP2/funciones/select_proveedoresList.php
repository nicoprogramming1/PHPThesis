<?php
function ObtenerListaProveedores($conexion) {
    $proveedor = array();
    $SQL = "SELECT nombreProveedor, idProveedor FROM proveedor";
    $resultado = mysqli_query($conexion, $SQL);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $proveedor[] = $fila;
    }
    return $proveedor;
}
?>