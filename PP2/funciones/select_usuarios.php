<?php
function Listar_Usuarios($vConexion) {
    $Listado = array();

        $SQL = "SELECT u.idUsuario, u.email, u.nombre, u.apellido, r.rol
        FROM usuarios u, roles r
        WHERE u.idRol = r.idRol
        ORDER BY u.idRol DESC";     

        $rs = mysqli_query($vConexion, $SQL);

        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {

            $Listado[$i]['ID'] = $data['idUsuario'];
            $Listado[$i]['EMAIL'] = $data['email'];
            $Listado[$i]['NOMBRE'] = $data['nombre'];
            $Listado[$i]['APELLIDO'] = $data['apellido'];
            $Listado[$i]['ROL'] = $data['rol'];
            
            $i++;
        }   
    
    return $Listado;
}