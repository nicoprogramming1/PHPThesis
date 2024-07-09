<?php
function countAsistentesEvento($MiConexion, $idEvento)
{
    $query = "SELECT COUNT(*) AS countAsistentes FROM asistentes_evento WHERE idEvento = $idEvento";

    $rs = mysqli_query($MiConexion, $query);

    // Verificar si se encontraron registros
    if ($rs) {
        $row = mysqli_fetch_assoc($rs);
        $countAsistentes = $row['countAsistentes'];
        return $countAsistentes > 0 ? $countAsistentes : 0;
    } else {
        return 0;
    }
}
?>