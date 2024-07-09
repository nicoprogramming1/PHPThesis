<?php
function Listar_Proveedores($conexion) {
    $proveedores = array();
    $SQL = "SELECT p.nombreProveedor, p.idProveedor, p.cuil, d.domicilio, e.email, t.telefono  FROM proveedor p, email e, domicilio d, telefono t
    WHERE p.idDomicilio = d.idDomicilio AND p.idEmail = e.idEmail AND p.idTelefono = t.idTelefono";
    $resultado = mysqli_query($conexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($resultado)) {
        $proveedores[$i]['IDPROVEEDOR'] = $data['idProveedor'];
        $proveedores[$i]['NOMBREPROVEEDOR'] = $data['nombreProveedor'];
        $proveedores[$i]['CUIL'] = $data['cuil'];
        $proveedores[$i]['DOMICILIO'] = $data['domicilio'];
        $proveedores[$i]['TELEFONO'] = $data['telefono'];
        $proveedores[$i]['EMAIL'] = $data['email'];
        $i++;
    }

    return $proveedores;
}
?>