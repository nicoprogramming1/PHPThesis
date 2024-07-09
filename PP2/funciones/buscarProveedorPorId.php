<?php
function ObtenerProveedorPorId($vConexion, $idProveedor) {
    $Proveedor = array();

    // Sanitiza y verifica el ID de la compra para evitar SQL injection
    $idProveedor = mysqli_real_escape_string($vConexion, $idProveedor);

    // Consulta para obtener los detalles del proveedor
    $SQL = "SELECT p.idProveedor, p.nombreProveedor, p.cuil, d.domicilio, d.idDomicilio, d.idCiudad, c.ciudad, e.email, e.idEmail, t.telefono, t.idTelefono
            FROM proveedor p
            INNER JOIN domicilio d ON p.idDomicilio = d.idDomicilio
            INNER JOIN ciudad c ON d.idCiudad = c.idCiudad
            INNER JOIN email e ON p.idEmail = e.idEmail
            INNER JOIN telefono t ON p.idTelefono = t.idTelefono
            WHERE p.idProveedor = $idProveedor";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Proveedor['IDPROVEEDOR'] = $data['idProveedor'];
        $Proveedor['NOMBREPROVEEDOR'] = $data['nombreProveedor'];
        $Proveedor['CUIL'] = $data['cuil'];
        $Proveedor['TELEFONO'] = $data['telefono'];
        $Proveedor['IDTELEFONO'] = $data['idTelefono'];
        $Proveedor['DOMICILIO'] = $data['domicilio'];
        $Proveedor['IDDOMICILIO'] = $data['idDomicilio'];
        $Proveedor['IDCIUDAD'] = $data['idCiudad'];
        $Proveedor['CIUDAD'] = $data['ciudad'];
        $Proveedor['EMAIL'] = $data['email'];
        $Proveedor['IDEMAIL'] = $data['idEmail'];
    }

    return $Proveedor;
}
?>