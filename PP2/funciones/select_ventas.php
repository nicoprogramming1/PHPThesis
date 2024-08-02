<?php
function Listar_Ventas($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM venta ORDER BY fechaVenta DESC";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDVENTA'] = $data['idVenta'];
        $Listado[$i]['FECHAVENTA'] = $data['fechaVenta'];
        $Listado[$i]['HORAVENTA'] = $data['horaVenta'];
        $Listado[$i]['IDESTADO'] = $data['idEstado'];
        $Listado[$i]['IDCAJERO'] = $data['idCajero'];
        $i++;
    }

    return $Listado;
}
?>