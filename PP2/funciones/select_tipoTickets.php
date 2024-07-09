<?php
function Listar_tipoTickets($vConexion) {
    $Listado = array();

    $SQL = "SELECT tt.idTipoTicket, tt.precioTicket, b1.bebida AS bebida1, b2.bebida AS bebida2, tt.tipoTicket 
            FROM tipo_ticket tt
            LEFT JOIN bebida b1 ON tt.idBebida1 = b1.idBebida
            LEFT JOIN bebida b2 ON tt.idBebida2 = b2.idBebida";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDTIPOTICKET'] = $data['idTipoTicket'];
        $Listado[$i]['PRECIOTICKET'] = $data['precioTicket'];
        $Listado[$i]['BEBIDA1'] = $data['bebida1'];
        $Listado[$i]['BEBIDA2'] = $data['bebida2'];
        $Listado[$i]['TIPOTICKET'] = $data['tipoTicket'];
        $i++;
    }

    return $Listado;
}
?>