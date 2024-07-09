<?php
function Validar_Seleccion_Modificar_Usuarios() {
    $vMensaje = '';

    // Verificar si se seleccionó un usuario
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un usuario para modificar. <br />';
    }

    // Validar otros campos si es necesario

    return $vMensaje;
}


function Validar_Datos_Modificar_Usuarios() {
    $vMensaje='';
        
    if (empty($_POST['email']) ) {
        $vMensaje.='Ingresa un email. <br />';
    }
    if (empty($_POST['nombre'])) {
        $vMensaje.='Ingresa un nombre. <br />';
    }
    if (empty($_POST['apellido'])) {
        $vMensaje.='Ingresa un apellido. <br />';
    }
    if (empty($_POST['clave'])) {
        $vMensaje.='Ingresa la contraseña. <br />';
    }
    
    //con esto aseguramos que limpiamos espacios y limpiamos de caracteres de codigo ingresados
    foreach($_POST as $Id=>$Valor){
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }
    return $vMensaje;
}


function Validar_Datos_Registrar_Usuarios() {
    $vMensaje='';
        
    if (empty($_POST['email']) ) {
        $vMensaje.='Ingresa un email. <br />';
    }
    if (empty($_POST['nombre'])) {
        $vMensaje.='Ingresa un nombre. <br />';
    }
    if (empty($_POST['apellido'])) {
        $vMensaje.='Ingresa un apellido. <br />';
    }
    if (empty($_POST['clave'])) {
        $vMensaje.='Ingresa una contraseña. <br />';
    }
    if (empty($_POST['roles'])) {
        $vMensaje.='Debes seleccionar un rol. <br />';
    }
    
    //con esto aseguramos que limpiamos espacios y limpiamos de caracteres de codigo ingresados
    foreach($_POST as $Id=>$Valor){
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }
    return $vMensaje;
}


function Validar_Carga_Roles() {
    $vMensaje = '';

    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    if (empty($_POST['rol'])) {
        $vMensaje .= 'Ingresa un rol. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Roles(){
    $vMensaje = '';

    // Verificar si se seleccionó un rol
    if (empty($_POST['roles'])) {
        $vMensaje .= 'Debes seleccionar un rol para modificar. <br />';
    }

    // con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    return $vMensaje;
}

function Validar_Modificar_Roles(){
    $vMensaje = '';

    // Verificar si se escribio un nombre
    if (empty($_POST['nuevoNombreRol'])) {
        $vMensaje .= 'No has ingresado un nombre. <br />';
    }

    // con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    return $vMensaje;
}

function Validar_Carga_Eventos() {
    $vMensaje='';
    // Validar que se haya seleccionado la fecha del evento
    if (empty($_POST['fechaEvento'])) {
        $vMensaje .= 'Por favor, selecciona la fecha del evento. <br />';
    }

    // Validar que se haya ingresado el detalle del evento
    if (empty($_POST['detalleEvento'])) {
        $vMensaje .= 'Por favor, ingresa el detalle del evento. <br />';
    }

    // con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Eventos() {
    $vMensaje = '';

    // Verificar si se seleccionó un usuario
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un evento para modificar. <br />';
    }

    // Validar otros campos si es necesario

    return $vMensaje;
}

function Validar_Modificar_Evento() {
    $vMensaje = '';

    // Validar los campos específicos para la modificación de eventos
    if (empty($_POST['fechaEvento'])) {
        $vMensaje .= 'Por favor, selecciona la nueva fecha del evento. <br />';
    }

    if (empty($_POST['detalleEvento'])) {
        $vMensaje .= 'Por favor, ingresa el nuevo detalle del evento. <br />';
    }

    // con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Promotores() {
    $vMensaje='';
        
    if (empty($_POST['nombre'])) {
        $vMensaje.='Ingresa un nombre. <br />';
    }
    if (empty($_POST['apellido'])) {
        $vMensaje.='Ingresa un apellido. <br />';
    }
    
    //con esto aseguramos que limpiamos espacios y limpiamos de caracteres de codigo ingresados
    foreach($_POST as $Id=>$Valor){
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }
    return $vMensaje;
}

function Validar_Seleccion_Modificar_Promotores() {
    $vMensaje = '';

    // Verificar si se seleccionó un promotor
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un promotor para modificar. <br />';
    }

    // Puedes agregar otras validaciones específicas para los promotores si es necesario

    return $vMensaje;
}

function Validar_Modificar_Promotores() {
    $vMensaje = '';

    // con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    // Validar los campos específicos para la modificación de eventos
    if (empty($_POST['nuevoNombrePromotor'])) {
        $vMensaje .= 'Por favor, ingresa el nombre. <br />';
    }

    if (empty($_POST['nuevoApellidoPromotor'])) {
        $vMensaje .= 'Por favor, ingresa el apellido. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Asistentes() {
    $vMensaje = '';

    // Validar el campo nombre
    if (empty($_POST['nombre'])) {
        $vMensaje .= 'Ingresa un nombre. <br />';
    }

    // Validar el campo dniAsistente
    if (empty($_POST['dniAsistente'])) {
        $vMensaje .= 'Ingresa el DNI del asistente. <br />';
    } else if (!ctype_digit($_POST['dniAsistente'])) {
        $vMensaje .= 'El DNI debe ser un número válido. <br />';
    }

    // Validar el campo promotorReferido
    if (empty($_POST['promotorReferido'])) {
        $vMensaje .= 'Debes seleccionar un promotor referido. <br />';
    } else if (!ctype_digit($_POST['promotorReferido'])) {
        $vMensaje .= 'El ID del promotor referido debe ser un número válido. <br />';
    }

    // Validar el campo evento
    if (empty($_POST['evento'])) {
        $vMensaje .= 'Debes seleccionar un evento. <br />';
    } else if (!ctype_digit($_POST['evento'])) {
        $vMensaje .= 'El ID del evento debe ser un número válido. <br />';
    }

    return $vMensaje;
}


function Validar_Seleccion_Modificar_Asistentes() {
    $vMensaje = '';

    // Verificar si se seleccionó un asistente
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un asistente para modificar. <br />';
    }

    // Puedes agregar otras validaciones específicas para los asistentees si es necesario

    return $vMensaje;
}

function Validar_Modificar_Asistentes() {
    $vMensaje = '';

    if (empty($_POST['nuevoNombreAsistente'])) {
        $vMensaje .= 'Ingresa un nombre. <br />';
    }

    if (empty($_POST['nuevoDniAsistente'])) {
        $vMensaje .= 'Ingresa el DNI del asistente. <br />';
    } else if (!ctype_digit($_POST['nuevoDniAsistente'])) {
        $vMensaje .= 'El DNI debe ser un número válido. <br />';
    }

    // Con esto aseguramos que limpiamos espacios y limpiamos de caracteres de código ingresados
    foreach ($_POST as $Id => $Valor) {
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Eventos() {
    $vMensaje = '';

    // Verificar si se seleccionó un evento
    if (empty($_POST['eventos'])) {
        $vMensaje .= 'Debes seleccionar un evento para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Planilla() {
    $vMensaje = '';

    // Verificar si se seleccionó un evento
    if (empty($_POST['eventos'])) {
        $vMensaje .= 'Debes seleccionar un evento para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registro_TipoTicket() {
    $vMensaje = '';

    // Verificar si el campo "Tipo de ticket" está vacío
    if (empty($_POST['tipoTicket'])) {
        $vMensaje .= 'El campo "Tipo de ticket" es obligatorio. <br />';
    }

    // Verificar si el campo "Precio de ticket" está vacío
    if (empty($_POST['precioTicket'])) {
        $vMensaje .= 'El campo "Precio de ticket" es obligatorio. <br />';
    } else {
        // Verificar si el campo "Precio de ticket" es un número positivo
        $precioTicket = $_POST['precioTicket'];
        if (!is_numeric($precioTicket) || $precioTicket <= 0) {
            $vMensaje .= 'El campo "Precio de ticket" debe ser un número positivo. <br />';
        }
    }

    // Verificar si el campo "Bebida 1" está vacío
    if (empty($_POST['primerBebida'])) {
        $vMensaje .= 'Debes seleccionar la "Bebida 1". <br />';
    }

    // Verificar si el campo "Bebida 2" está vacío
    if (empty($_POST['segundaBebida'])) {
        $vMensaje .= 'Debes seleccionar la "Bebida 2". <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_TipoTickets() {
    $vMensaje = '';

    // Verificar si se seleccionó un tipo de ticket
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un tipo de ticket para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Modificar_TipoTicket() {
    $vMensaje = '';

    // Verificar si se seleccionó un tipo de ticket
    if (empty($_POST['nuevoTipoTicket'])) {
        $vMensaje .= 'Debes seleccionar un tipo de ticket para consultar sus detalles. <br />';
    }

    // Verificar si el campo "Precio de ticket" está vacío
    if (empty($_POST['nuevoPrecioTicket'])) {
        $vMensaje .= 'El campo "Precio de ticket" es obligatorio. <br />';
    } else {
        // Verificar si el campo "Precio de ticket" es un número positivo
        $precioTicket = $_POST['nuevoPrecioTicket'];
        if (!is_numeric($precioTicket) || $precioTicket <= 0) {
            $vMensaje .= 'El campo "Precio de ticket" debe ser un número positivo. <br />';
        }
    }

    // Verificar si se seleccionó la primera bebida
    if (empty($_POST['nuevaPrimeraBebida'])) {
        $vMensaje .= 'Debes seleccionar la primera bebida asociada al tipo de ticket. <br />';
    }

    // Verificar si se seleccionó la segunda bebida (opcional)
    if (empty($_POST['nuevaSegundaBebida'])) {
        $vMensaje .= 'Debes seleccionar la segunda bebida asociada al tipo de ticket. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registro_Venta() {
    $vMensaje = '';
    $alMenosUnoMayorACero = false;

    foreach ($_POST as $nombreCampo => $valor) {
        if (strpos($nombreCampo, 'cantidad_') !== false) {
            $cantidad = (int)$valor;
            if ($cantidad < 0) {
                $vMensaje .= 'La cantidad para el ticket ' . substr($nombreCampo, 9) . ' debe ser un número positivo o cero.<br>';
            } else if ($cantidad > 0) {
                $alMenosUnoMayorACero = true;
            }
        }
    }

    if (!$alMenosUnoMayorACero) {
        $vMensaje .= 'Debes seleccionar al menos un ticket con cantidad mayor a cero.<br>';
    }

    return $vMensaje;
}

function Validar_Seleccion_Cancelar_Venta() {
    $vMensaje = '';

    // Verificar si se seleccionó un tipo de ticket
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una venta para cancelarla. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_OrdenCompra() {
    $vMensaje = '';
    $alMenosUnaBebidaSeleccionada = false;

    // Validar si se ha seleccionado un proveedor
    $proveedor = $_POST['proveedor'];
    if (empty($proveedor)) {
        $vMensaje .= 'Debes seleccionar un proveedor.<br>';
    }

    // Recorremos las bebidas y validamos la cantidad
    foreach ($_POST as $nombreCampo => $valor) {
        if (strpos($nombreCampo, 'cantidad_') !== false) {
            $cantidad = (int)$valor;
            if ($cantidad < 0) {
                $vMensaje .= 'La cantidad para la bebida ' . substr($nombreCampo, 9) . ' debe ser un número positivo o cero.<br>';
            } elseif ($cantidad > 0) {
                // Si al menos una cantidad es mayor a 0, marcamos que se seleccionó al menos una bebida.
                $alMenosUnaBebidaSeleccionada = true;
            }
        }
    }

    // Comprobar si al menos una bebida se seleccionó
    if (!$alMenosUnaBebidaSeleccionada) {
        $vMensaje .= 'Debes seleccionar al menos una bebida con cantidad mayor a cero.<br>';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_OrdenCompra() {
    $vMensaje = '';

    // Verificar si se seleccionó una orden de compra
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una orden de compra para consultar sus detalles o enviarla.';
    }

    return $vMensaje;
}

function Validar_Modificar_OrdenCompra() {
    $vMensaje = '';

    

    return $vMensaje;
}

function Validar_Seleccion_Consultas_OrdenesCompra() {
    $vMensaje = '';

    // Verificar si se seleccionó una orden de compra
    if (empty($_POST['ordenes'])) {
        $vMensaje .= 'Debes seleccionar una orden de compra para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Factura() {
    $vMensaje = '';

    if (empty($_POST['nroFactura'])) {
        $vMensaje .= 'Ingresa el número de la factura. <br />';
    }
    if (empty($_POST['importeFactura'])) {
        $vMensaje .= 'Ingresa un importe. <br />';
    } elseif (!is_numeric($_POST['importeFactura']) || $_POST['importeFactura'] <= 0) {
        $vMensaje .= 'El importe debe ser un número positivo. <br />';
    }
    if (empty($_FILES['factura']['name'])) {
        $vMensaje .= 'Carga la factura. <br />';
    }
    if (empty($_POST['proveedor'])) {
        $vMensaje .= 'Selecciona un proveedor. <br />';
    }
    if (empty($_POST['fechaFactura'])) {
        $vMensaje .= 'Selecciona la fecha de la factura. <br />';
    } else {
        $fechaFactura = $_POST['fechaFactura'];
        $fechaPartes = explode('/', $fechaFactura);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Facturas() {
    $vMensaje = '';

    // Verificar si se seleccionó una factura
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una factura para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Factura() {
    $vMensaje = '';

    if (empty($_POST['nroFactura'])) {
        $vMensaje .= 'Ingresa el número de la factura. <br />';
    }
    if (empty($_POST['importeFactura'])) {
        $vMensaje .= 'Ingresa un importe. <br />';
    } elseif (!is_numeric($_POST['importeFactura']) || $_POST['importeFactura'] <= 0) {
        $vMensaje .= 'El importe debe ser un número positivo. <br />';
    }
    if (empty($_POST['proveedor'])) {
        $vMensaje .= 'Selecciona un proveedor. <br />';
    }
    if (empty($_POST['fechaFactura'])) {
        $vMensaje .= 'Selecciona la fecha de la factura. <br />';
    } else {
        $fechaFactura = $_POST['fechaFactura'];
        $fechaPartes = explode('/', $fechaFactura);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Compra() {
    $vMensaje = '';

    if (empty($_POST['factura'])) {
        $vMensaje .= 'Selecciona una factura. <br />';
    }
    if (empty($_POST['ordenCompra'])) {
        $vMensaje .= 'Selecciona una orden de compra. <br />';
    }
    return $vMensaje;
}

function Validar_Seleccion_Modificar_Compras() {
    $vMensaje = '';

    // Verificar si se seleccionó una factura
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una compra para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Compra() {
    $vMensaje = '';

    if (empty($_POST['factura'])) {
        $vMensaje .= 'Selecciona una factura. <br />';
    }
    if (empty($_POST['ordenCompra'])) {
        $vMensaje .= 'Selecciona una orden de compra. <br />';
    }
    return $vMensaje;
}

function Validar_Datos_Registrar_Proveedor() {
    $vMensaje = '';

    if (empty($_POST['nombreProveedor'])) {
        $vMensaje .= 'Ingresa el nombre del proveedor. <br />';
    }
    if (empty($_POST['cuil'])) {
        $vMensaje .= 'Ingresa el cuil. <br />';
    }
    if (empty($_POST['domicilio'])) {
        $vMensaje .= 'Ingresa el domicilio. <br />';
    }
    if (empty($_POST['telefono'])) {
        $vMensaje .= 'Ingresa el telefono del proveedor. <br />';
    }
    if (empty($_POST['email']) || !strpos($_POST['email'], '@')) {
        $vMensaje .= 'Ingresa un email válido. <br />';
    }
    if (empty($_POST['ciudad'])) {
        $vMensaje .= 'Selecciona una ciudad. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Proveedor() {
    $vMensaje = '';

    // Verificar si se seleccionó un proveedor
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un proveedor para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Proveedor() {
    $vMensaje = '';

    if (empty($_POST['nombreProveedor'])) {
        $vMensaje .= 'Ingresa el nombre del proveedor. <br />';
    }

    if (empty($_POST['cuil'])) {
        $vMensaje .= 'Ingresa el CUIL del proveedor. <br />';
    }

    if (empty($_POST['email'])) {
        $vMensaje .= 'Ingresa el email del proveedor. <br />';
    }

    if (empty($_POST['telefono'])) {
        $vMensaje .= 'Ingresa el teléfono del proveedor. <br />';
    }

    if (empty($_POST['domicilio'])) {
        $vMensaje .= 'Ingresa el domicilio del proveedor. <br />';
    }

    if (empty($_POST['ciudad'])) {
        $vMensaje .= 'Selecciona una ciudad. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Proveedores() {
    $vMensaje = '';

    // Verificar si se seleccionó un proveedor
    if (empty($_POST['listaProveedores'])) {
        $vMensaje .= 'Debes seleccionar un proveedor para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Cotizacion() {
    $vMensaje = '';

    if (empty($_POST['proveedor'])) {
        $vMensaje .= 'Selecciona un proveedor. <br />';
    }

    if (empty($_POST['fechaCotizacion'])) {
        $vMensaje .= 'Selecciona la fecha de la cotización. <br />';
    } else {
        $fechaCotizacion = $_POST['fechaCotizacion'];
        $fechaPartes = explode('/', $fechaCotizacion);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Cotizaciones() {
    $vMensaje = '';

    // Verificar si se seleccionó una cotizacion
    if (empty($_POST['listaProveedores'])) {
        $vMensaje .= 'Debes seleccionar una cotización para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Cotizaciones() {
    $vMensaje = '';

    // Verificar si se seleccionó una cotizacion
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una cotización para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Cotizacion() {
    $vMensaje = '';

    if (empty($_POST['nombreProveedor'])) {
        $vMensaje .= 'Selecciona una cotización. <br />';
    }
    if (empty($_POST['fechaCotizacion'])) {
        $vMensaje .= 'Selecciona la fecha de la cotización. <br />';
    } else {
        $fechaFactura = $_POST['fechaCotizacion'];
        $fechaPartes = explode('/', $fechaFactura);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Cotizaciones_Proveedor() {
    $vMensaje = '';

    // Verificar si se seleccionó un proveedor
    if (empty($_POST['listaProveedores'])) {
        $vMensaje .= 'Debes seleccionar un proveedor para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Recibo() {
    $vMensaje = '';

    if (empty($_POST['nroRecibo'])) {
        $vMensaje .= 'Ingresa el número del recibo. <br />';
    } else {
        $numeroRecibo = $_POST['nroRecibo'];
        if (!preg_match('/^\d+$/', $numeroRecibo)) {
            $vMensaje .= 'El número del recibo debe ser un número entero positivo. <br />';
        }
    }
    if (empty($_FILES['recibo']['name'])) {
        $vMensaje .= 'Carga el recibo. <br />';
    }
    if (empty($_POST['idCompra'])) {
        $vMensaje .= 'Selecciona una compra. <br />';
    }
    if (empty($_POST['fechaRecibo'])) {
        $vMensaje .= 'Selecciona la fecha del recibo. <br />';
    } else {
        $fechaRecibo = $_POST['fechaRecibo'];
        $fechaPartes = explode('/', $fechaRecibo);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Recibos() {
    $vMensaje = '';

    // Verificar si se seleccionó un recibo
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un recibo para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Recibo() {
    $vMensaje = '';

    if (empty($_POST['nroRecibo'])) {
        $vMensaje .= 'Ingresa el número del recibo. <br />';
    } else {
        $numeroRecibo = $_POST['nroRecibo'];
        if (!preg_match('/^\d+$/', $numeroRecibo)) {
            $vMensaje .= 'El número del recibo debe ser un número entero positivo. <br />';
        }
    }
    if (empty($_POST['idCompra'])) {
        $vMensaje .= 'Selecciona una compra. <br />';
    }
    if (empty($_POST['fechaRecibo'])) {
        $vMensaje .= 'Selecciona la fecha del recibo. <br />';
    } else {
        $fechaRecibo = $_POST['fechaRecibo'];
        $fechaPartes = explode('/', $fechaRecibo);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Bebida() {
    $vMensaje = '';

    if (empty($_POST['bebida'])) {
        $vMensaje .= 'Ingresa el nombre de la bebida. <br />';
    }
    if (empty($_POST['marca'])) {
        $vMensaje .= 'Selecciona una marca. <br />';
    }
    if (empty($_POST['volumen'])) {
        $vMensaje .= 'Selecciona un volumen. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Bebida() {
    $vMensaje = '';

    // Verificar si se seleccionó una bebida
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una bebida para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Bebida() {
    $vMensaje = '';

    if (empty($_POST['bebida'])) {
        $vMensaje .= 'Ingresa el nombre de la bebida. <br />';
    }
    if (empty($_POST['marca'])) {
        $vMensaje .= 'Selecciona la marca. <br />';
    }
    if (empty($_POST['volumen'])) {
        $vMensaje .= 'Selecciona el volumen. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Bebidas() {
    $vMensaje = '';

    // Verificar si se seleccionó una bebida
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una bebida para consultar. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Volumen() {
    $vMensaje = '';

    // Verificar si se seleccionó un volumen
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un volumen para consultar. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_VentasPorFecha() {
    $vMensaje = '';

    // Verificar si se seleccionó un volumen
    if (empty($_POST['fechaVenta1'])) {
        $vMensaje .= 'Debes seleccionar una fecha de inicio para consultar. <br />';
    }
    // Verificar si se seleccionó un volumen
    if (empty($_POST['fechaVenta2'])) {
        $vMensaje .= 'Debes seleccionar una fecha de fin para consultar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Marca() {
    $vMensaje = '';

    if (empty($_POST['marca'])) {
        $vMensaje .= 'Ingresa el nombre de la marca. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Marca() {
    $vMensaje = '';

    // Verificar si se seleccionó una marca
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una marca para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Marca() {
    $vMensaje = '';

    if (empty($_POST['marca'])) {
        $vMensaje .= 'Ingresa el nombre de la marca. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Marcas() {
    $vMensaje = '';

    // Verificar si se seleccionó una marca
    if (empty($_POST['marca'])) {
        $vMensaje .= 'Debes seleccionar una marca para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Recepcion() {
    $vMensaje = '';

    if (empty($_POST['nroRemito'])) {
        $vMensaje .= 'Ingresa el número del remito. <br />';
    } else {
        $numeroRecibo = $_POST['nroRemito'];
        if (!preg_match('/^\d+$/', $numeroRecibo)) {
            $vMensaje .= 'El número del remito debe ser un número entero positivo. <br />';
        }
    }
    if (empty($_FILES['remito']['name'])) {
        $vMensaje .= 'Carga el remito. <br />';
    }
    if (empty($_POST['compra'])) {
        $vMensaje .= 'Selecciona una compra. <br />';
    }
    if ($_POST['estadoRecepcion'] === "") {
        $vMensaje .= 'Selecciona un estado para la recepción. <br />';
    }
    if (empty($_POST['fechaRemito'])) {
        $vMensaje .= 'Selecciona la fecha del remito. <br />';
    } else {
        $fechaRemito = $_POST['fechaRemito'];
        $fechaPartes = explode('/', $fechaRemito);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }
    if (empty($_POST['fechaRecepcion'])) {
        $vMensaje .= 'Selecciona la fecha de la recepción. <br />';
    } else {
        $fechaRecepcion = $_POST['fechaRecepcion'];
        $fechaPartes = explode('/', $fechaRecepcion);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    global $ListadoBebidas;

    $alMenosUnaBebidaIngresada = false; // Variable para controlar que al menos una bebida tenga una cantidad ingresada

    foreach ($ListadoBebidas as $bebida) {
        $idBebida = $bebida['IDBEBIDA'];
        $campoCantidad = 'cantidad_' . $idBebida;

        // Verificar si se ingresó una cantidad para esta bebida
        if (!empty($_POST[$campoCantidad])) {
            $cantidadIngresada = $_POST[$campoCantidad];

            // Validar que sea un número positivo
            if (!preg_match('/^\d+$/', $cantidadIngresada)) {
                $vMensaje .= "La cantidad para la bebida con ID $idBebida no es un número entero positivo.<br />";
            } else {
                // Si al menos una bebida tiene una cantidad ingresada, activamos el flag
                $alMenosUnaBebidaIngresada = true;
            }
        }
    }

    // Si ninguna bebida tiene cantidad ingresada, mostrar un mensaje de error
    if (!$alMenosUnaBebidaIngresada) {
        $vMensaje .= 'Debes ingresar al menos una cantidad para una bebida.<br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Recepciones() {
    $vMensaje = '';

    // Verificar si se seleccionó una recepcion
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una recepción para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Recepcion() {
    $vMensaje = '';

    if (empty($_POST['nroRemito'])) {
        $vMensaje .= 'Ingresa el número del remito. <br />';
    } else {
        $numeroRecibo = $_POST['nroRemito'];
        if (!preg_match('/^\d+$/', $numeroRecibo)) {
            $vMensaje .= 'El número del remito debe ser un número entero positivo. <br />';
        }
    }
    if (empty($_POST['compra'])) {
        $vMensaje .= 'Selecciona una compra. <br />';
    }
    if ($_POST['estadoRecepcion'] === "") {
        $vMensaje .= 'Selecciona un estado para la recepción. <br />';
    }
    if (empty($_POST['fechaRemito'])) {
        $vMensaje .= 'Selecciona la fecha del remito. <br />';
    } else {
        $fechaRemito = $_POST['fechaRemito'];
        $fechaPartes = explode('/', $fechaRemito);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }
    if (empty($_POST['fechaRecepcion'])) {
        $vMensaje .= 'Selecciona la fecha de la recepción. <br />';
    } else {
        $fechaRecepcion = $_POST['fechaRecepcion'];
        $fechaPartes = explode('/', $fechaRecepcion);
        if (count($fechaPartes) != 3) {
            $vMensaje .= 'La fecha debe estar en formato dd/mm/yy. <br />';
        } else {
            $dia = (int)$fechaPartes[0];
            $mes = (int)$fechaPartes[1];
            $anio = (int)$fechaPartes[2];
            if (!checkdate($mes, $dia, $anio)) {
                $vMensaje .= 'La fecha debe ser válida. <br />';
            }
        }
    }

    return $vMensaje;
}


function Validar_Datos_Restar_Bebidas() {
    $vMensaje = '';

    if (empty($_POST['detalleRestarBebida'])) {
        $vMensaje .= 'Ingresa el detalle de la operación. <br />';
    }

    global $ListadoBebidas;

    $alMenosUnaBebidaIngresada = false; // Variable para controlar que al menos una bebida tenga una cantidad ingresada

    foreach ($ListadoBebidas as $bebida) {
        $idBebida = $bebida['IDBEBIDA'];
        $campoCantidad = 'cantidad_' . $idBebida;

        // Verificar si se ingresó una cantidad para esta bebida
        if (!empty($_POST[$campoCantidad])) {
            $cantidadIngresada = $_POST[$campoCantidad];

            // Validar que sea un número positivo
            if (!preg_match('/^\d+$/', $cantidadIngresada)) {
                $vMensaje .= "La cantidad para la bebida con ID $idBebida no es un número entero positivo.<br />";
            } else {
                // Si al menos una bebida tiene una cantidad ingresada, activamos el flag
                $alMenosUnaBebidaIngresada = true;
            }
        }
    }
}

function Validar_Seleccion_Consultas_Recepciones() {
    $vMensaje = '';

    // Verificar si se seleccionó una recepcion
    if (empty($_POST['listaRecepciones'])) {
        $vMensaje .= 'Elije una recepción de la lista o todas. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Recepciones_Detalles() {
    $vMensaje = '';

    // Verificar si se seleccionó una recepcion
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar una recepción para consultar sus detalles. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Registrar_Reclamo() {
    $vMensaje = '';

    if (empty($_POST['detalleReclamo'])) {
        $vMensaje .= 'Debes ingresar el detalle del reclamo. <br />';
    }

    if (empty($_POST['proveedor'])) {
        $vMensaje .= 'Debes seleccionar un proveedor. <br />';
    }

    if (empty($_POST['recepcionCompra'])) {
        $vMensaje .= 'Debes seleccionar una recepción. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Modificar_Reclamos() {
    $vMensaje = '';

    // Verificar si se seleccionó un reclamo
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un reclamo para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Datos_Modificar_Reclamo() {
    $vMensaje = '';

    // Verificar si se seleccionó un reclamo
    if (empty($_POST['detalleReclamo'])) {
        $vMensaje .= 'Debes ingresar un detalle para modificar. <br />';
    }

    if (empty($_POST['proveedor'])) {
        $vMensaje .= 'Debes seleccionar un proveedor para modificar. <br />';
    }

    if (empty($_POST['recepcionCompra'])) {
        $vMensaje .= 'Debes seleccionar una recepcion de compra para modificar. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Enviar_Reclamos() {
    $vMensaje = '';

    // Verificar si se seleccionó un reclamo
    if (empty($_POST['seleccionar'])) {
        $vMensaje .= 'Debes seleccionar un reclamo para enviar. <br />';
    }

    return $vMensaje;
}

function Validar_Seleccion_Consultas_Reclamos() {
    $vMensaje = '';

    // Verificar si se seleccionó un reclamo
    if (empty($_POST['reclamos'])) {
        $vMensaje .= 'Debes seleccionar un reclamo para consultar. <br />';
    }

    return $vMensaje;
}
?>