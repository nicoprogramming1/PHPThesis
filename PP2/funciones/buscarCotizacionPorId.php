<?php
function ObtenerCotizacionPorId($vConexion, $idCotizacion) {
    $Cotizacion = array();

    // Sanitiza y verifica el ID de la cotizacion para evitar SQL injection
    $idCotizacion = mysqli_real_escape_string($vConexion, $idCotizacion);

    // Consulta para obtener los detalles de la cotizacion
    $SQL = "SELECT p.nombreProveedor, p.idProveedor, c.idCotizacion, c.fechaCotizacion, c.cotizacionImagen, c.cotizacionTexto, c.detalleCotizacion  
            FROM proveedor p
            LEFT JOIN cotizacion c ON p.idProveedor = c.idProveedor
            WHERE c.idCotizacion = '$idCotizacion'";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Cotizacion['IDCOTIZACION'] = $data['idCotizacion'];
        $Cotizacion['NOMBREPROVEEDOR'] = $data['nombreProveedor'];
        $Cotizacion['FECHACOTIZACION'] = $data['fechaCotizacion'];
        $Cotizacion['COTIZACIONIMAGEN'] = $data['cotizacionImagen'];
        $Cotizacion['COTIZACIONTEXTO'] = $data['cotizacionTexto'];
        $Cotizacion['DETALLECOTIZACION'] = $data['detalleCotizacion'];
        $Cotizacion['IDPROVEEDOR'] = $data['idProveedor'];
    }

    return $Cotizacion;
}
?>