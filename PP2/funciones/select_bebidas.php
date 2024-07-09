<?php
function Listar_Bebidas($vConexion) {
    $Listado = array();

    $SQL = "SELECT b.bebida, b.idBebida, m.marca, v.volumen, b.idVolumen, b.idMarca, b.cantidadBebidas
            FROM bebida b, marca m, volumen v
            WHERE b.idVolumen = v.idVolumen AND b.idMarca = m.idMarca ORDER BY b.bebida";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDBEBIDA'] = $data['idBebida'];
        $Listado[$i]['BEBIDA'] = $data['bebida'];
        $Listado[$i]['IDMARCA'] = $data['idMarca'];
        $Listado[$i]['MARCA'] = $data['marca'];
        $Listado[$i]['VOLUMEN'] = $data['volumen'];
        $Listado[$i]['IDVOLUMEN'] = $data['idVolumen'];
        $Listado[$i]['CANTIDAD'] = $data['cantidadBebidas'];
        $i++;
    }

    return $Listado;
}
?>