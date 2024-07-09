<option value="">Selecciona...</option>
<?php 
$selected = '';
for ($i = 0; $i < $CantidadRoles; $i++) {
    if (!empty($_POST['Roles']) && $_POST['Roles'] ==  $ListadoRoles[$i]['ROLES']) {
        $selected = 'selected';
    } else {
        $selected = '';
    }
?>
<option value="<?php echo $ListadoRoles[$i]['ROLES']; ?>" <?php echo $selected; ?>>
    <?php echo $ListadoRoles[$i]['ROLES']; ?>
</option>
<?php } ?> 