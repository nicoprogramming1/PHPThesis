<?php
function Listar_Cotizaciones($conexion) {
    $cotizaciones = array();
    $SQL = "SELECT p.nombreProveedor, c.idCotizacion, c.fechaCotizacion, c.cotizacionImagen, c.cotizacionTexto, c.detalleCotizacion    FROM proveedor p
            LEFT JOIN cotizacion c ON p.idProveedor = c.idProveedor
            ORDER BY c.fechaCotizacion DESC";

    $resultado = mysqli_query($conexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($resultado)) {
        $cotizaciones[$i]['IDCOTIZACION'] = $data['idCotizacion'];
        $cotizaciones[$i]['NOMBREPROVEEDOR'] = $data['nombreProveedor'];
        $cotizaciones[$i]['FECHACOTIZACION'] = $data['fechaCotizacion'];
        $cotizaciones[$i]['COTIZACIONIMAGEN'] = $data['cotizacionImagen'];
        $cotizaciones[$i]['COTIZACIONTEXTO'] = $data['cotizacionTexto'];
        $cotizaciones[$i]['DETALLECOTIZACION'] = $data['detalleCotizacion'];
        $i++;
    }

    return $cotizaciones;
}
?>