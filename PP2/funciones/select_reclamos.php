<?php
function Listar_Reclamos($vConexion) {
    $Listado = array();

    $SQL = "SELECT r.idReclamo, r.fechaReclamo, r.fechaCambioEstadoReclamo, e.estadoReclamo, d.detalleReclamo, p.nombreProveedor, d.idRecepcionCompra
            FROM reclamo r
            INNER JOIN estado_reclamo e ON r.idEstadoReclamo = e.idEstadoReclamo
            INNER JOIN detalle_reclamo d ON r.idReclamo = d.idReclamo
            INNER JOIN proveedor p ON d.idProveedor = p.idProveedor";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDRECLAMO'] = $data['idReclamo'];
        $Listado[$i]['FECHARECLAMO'] = $data['fechaReclamo'];
        $Listado[$i]['FECHACAMBIOESTADORECLAMO'] = $data['fechaCambioEstadoReclamo'];
        $Listado[$i]['ESTADORECLAMO'] = $data['estadoReclamo'];
        $Listado[$i]['DETALLERECLAMO'] = $data['detalleReclamo'];
        $Listado[$i]['NOMBREPROVEEDOR'] = $data['nombreProveedor'];
        $Listado[$i]['IDRECEPCIONCOMPRA'] = $data['idRecepcionCompra'];
        $i++;
    }

    return $Listado;
}
?>