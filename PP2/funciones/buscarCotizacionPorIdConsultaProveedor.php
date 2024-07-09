<?php
function ObtenerCotizacionPorIdConsultaProveedor($vConexion, $selectedProveedor) {
    $cotizaciones = array();

    // Sanitiza y verifica el ID del proveedor para evitar SQL injection
    $selectedProveedor = mysqli_real_escape_string($vConexion, $selectedProveedor);

    // Consulta para obtener los detalles de la cotizacion ordenados por fecha descendente
    $SQL = "SELECT p.nombreProveedor, p.idProveedor, c.idCotizacion, c.fechaCotizacion
            FROM proveedor p
            INNER JOIN cotizacion c ON c.idProveedor = p.idProveedor
            WHERE c.idProveedor = '$selectedProveedor'
            ORDER BY c.fechaCotizacion DESC";  // Ordena por fecha descendente

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        while ($data = mysqli_fetch_array($rs)) {
            $cotizacion = array(
                'IDCOTIZACION' => $data['idCotizacion'],
                'NOMBREPROVEEDOR' => $data['nombreProveedor'],
                'FECHACOTIZACION' => $data['fechaCotizacion'],
                'IDPROVEEDOR' => $data['idProveedor']
            );
            $cotizaciones[] = $cotizacion;
        }
    }

    return $cotizaciones;
}
?>