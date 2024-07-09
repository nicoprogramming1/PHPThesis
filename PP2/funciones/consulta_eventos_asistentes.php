<?php
function countAsistentesEvento($MiConexion, $idEvento)
{
    $query = "SELECT COUNT(*) AS countAsistentes FROM asistentes_evento WHERE idEvento = ?";
    $stmt = $MiConexion->prepare($query);
    $stmt->bind_param('i', $idEvento);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontraron registros
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $countAsistentes = $row['countAsistentes'];
        return $countAsistentes > 0 ? $countAsistentes : 0;
    } else {
        return 0;
    }
}
?>