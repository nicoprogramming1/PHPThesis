<ul class="pc-navbar">

	<?php if ($_SESSION['Usuario_Rol'] == 'admin' || $_SESSION['Usuario_Rol'] == 'gerente') { ?>
	<li class="pc-item pc-caption">
		<label>Administración de Usuarios</label>
	</li>
	<li class="pc-item"><a href="cargar_usuario.php" class="pc-link ">
	    <span class="pc-micon"><i data-feather="list"></i></span>
	    <span class="pc-mtext">Cargar nuevo usuario</span></a>
	</li>
	<li class="pc-item"><a href="listado_usuarios.php" class="pc-link ">
	    <span class="pc-micon"><i data-feather="list"></i></span>
	    <span class="pc-mtext">Listado de usuarios</span></a>
	</li>
	<li class="pc-item pc-caption">
		<label>Administración de Roles</label>
	</li>
	<li class="pc-item"><a href="cargar_rol.php" class="pc-link ">
	    <span class="pc-micon"><i data-feather="list"></i></span>
	    <span class="pc-mtext">Agregar rol</span></a>
	</li>
	<li class="pc-item"><a href="listado_roles.php" class="pc-link ">
	    <span class="pc-micon"><i data-feather="list"></i></span>
	    <span class="pc-mtext">Actualizar roles</span></a>
	</li>
	
	<?php } ?>


	<?php if ($_SESSION['Usuario_Rol'] == 'encargado_stock' || $_SESSION['Usuario_Rol'] == 'gerente' || $_SESSION['Usuario_Rol'] == 'admin') { ?>

	<li class="pc-item pc-caption">
			<label>Gestión de Stock</label>
		</li>
		<li class="pc-item"><a href="cargar_recepcionCompra.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar recepción de compra</span></a>
		</li>
		<li class="pc-item"><a href="listado_recepciones.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar recepción de compra</span></a>
		</li>
		<li class="pc-item"><a href="consulta_recepciones.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar recepción de compra</span></a>
		</li>
		<li class="pc-item"><a href="cargar_reclamo.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar reclamo</span></a>
		</li>
		<li class="pc-item"><a href="listado_reclamos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar reclamo</span></a>
		</li>
		<li class="pc-item"><a href="consulta_reclamos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar reclamo</span></a>
		</li>
		<li class="pc-item"><a href="cargar_marca.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar marca</span></a>
		</li>
		<li class="pc-item"><a href="listado_marcas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar marca</span></a>
		</li>
		<li class="pc-item"><a href="consulta_marcas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar marca</span></a>
		</li>
		<li class="pc-item"><a href="cargar_bebida.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar bebida</span></a>
		</li>
		<li class="pc-item"><a href="listado_bebidas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar bebida</span></a>
		</li>
		<li class="pc-item"><a href="consulta_bebidas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar bebida</span></a>
		</li>
		<li class="pc-item"><a href="consulta_bebidasPorMarca.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar bebidas por marca</span></a>
		</li>
		<li class="pc-item"><a href="consulta_bebidasPorVolumen.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar bebidas por volumen</span></a>
		</li>
		<li class="pc-item"><a href="restar_bebidas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Restar bebidas</span></a>
		</li>
		

	<?php } ?>



	<?php if ($_SESSION['Usuario_Rol'] == 'encargado_proveedores' || $_SESSION['Usuario_Rol'] == 'gerente' || $_SESSION['Usuario_Rol'] == 'admin') { ?>

	<li class="pc-item pc-caption">
			<label>Gestión de Proveedores</label>
		</li>
		<li class="pc-item"><a href="cargar_proveedor.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar proveedor</span></a>
		</li>
		<li class="pc-item"><a href="listado_proveedores.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar proveedor</span></a>
		</li>
		<li class="pc-item"><a href="consulta_proveedores.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar proveedor</span></a>
		</li>
		<li class="pc-item"><a href="cargar_cotizacion.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar cotización</span></a>
		</li>
		<li class="pc-item"><a href="listado_cotizaciones.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Modificar cotización</span></a>
		</li>
		<li class="pc-item"><a href="consulta_cotizaciones.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar cotización</span></a>
		</li>
		<li class="pc-item"><a href="consulta_cotizacionesPorProveedor.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar últimas cotizaciones por proveedor</span></a>
		</li>
		<li class="pc-item"><a href="consulta_proveedoresMasConcurridos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar proveedores más concurridos</span></a>
		</li>
		

	<?php } ?>


	<?php if ($_SESSION['Usuario_Rol'] == 'encargado_compras' || $_SESSION['Usuario_Rol'] == 'gerente' || $_SESSION['Usuario_Rol'] == 'admin') { ?>

	<li class="pc-item pc-caption">
			<label>Gestión de Compras</label>
		</li>
		<li class="pc-item"><a href="cargar_compra.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar compra</span></a>
		</li>
		<li class="pc-item"><a href="listado_compras.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar compra</span></a>
		</li>
		<li class="pc-item"><a href="consulta_compras.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar compra</span></a>
		</li>
		<li class="pc-item"><a href="consulta_proveedoresMasComprados.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar compras por proveedor</span></a>
		</li>
		<li class="pc-item"><a href="cargar_ordenCompra.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar orden de compra</span></a>
		</li>
		<li class="pc-item"><a href="listado_ordenCompra.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar orden de compra</span></a>
		</li>
		<li class="pc-item"><a href="consulta_ordenesCompra.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar orden de compra</span></a>
		</li>
		<li class="pc-item"><a href="cargar_factura.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar factura</span></a>
		</li>
		<li class="pc-item"><a href="listado_facturas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar factura</span></a>
		</li>
		<li class="pc-item"><a href="listado_facturasConsulta.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar factura</span></a>
		</li>
		<li class="pc-item"><a href="cargar_recibo.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar recibo</span></a>
		</li>
		<li class="pc-item"><a href="listado_recibos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Modificar recibo</span></a>
		</li>
		<li class="pc-item"><a href="consulta_recibos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultar recibo</span></a>
		</li>
		

	<?php } ?>

	<?php if ($_SESSION['Usuario_Rol'] == 'encargado_ventas' || $_SESSION['Usuario_Rol'] == 'gerente' || $_SESSION['Usuario_Rol'] == 'admin') { ?>

	<li class="pc-item pc-caption">
			<label>Gestión de Ventas</label>
		</li>
		<li class="pc-item"><a href="cargar_venta.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar venta</span></a>
		</li>
		<li class="pc-item"><a href="listado_ventas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar venta</span></a>
		</li>
		<li class="pc-item"><a href="cargar_tipoTicket.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar tipo de ticket</span></a>
		</li>
		<li class="pc-item"><a href="listado_tipoTickets.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar tipo de ticket</span></a>
		</li>
		<li class="pc-item"><a href="consulta_ventas.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consulta de ventas por evento</span></a>
		</li>
		<li class="pc-item"><a href="consulta_ventasPorFecha.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consulta de ventas por fecha</span></a>
		</li>

	<?php } ?>

	<?php if ($_SESSION['Usuario_Rol'] == 'encargado_planillas' || $_SESSION['Usuario_Rol'] == 'gerente' || $_SESSION['Usuario_Rol'] == 'admin') { ?>

	<li class="pc-item pc-caption">
			<label>Gestión de Asistentes</label>
		</li>
		<li class="pc-item"><a href="planilla_asistentes.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Planilla de asistentes</span></a>
		</li>
		<li class="pc-item"><a href="cargar_evento.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar evento</span></a>
		</li>
		<li class="pc-item"><a href="listado_eventos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar evento</span></a>
		</li>
		<li class="pc-item"><a href="consulta_eventos.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultas de asistentes por eventos</span></a>
		</li>
		<li class="pc-item"><a href="cargar_asistente.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar asistente a evento</span></a>
		</li>
		<li class="pc-item"><a href="cargar_promotor.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Agregar promotor</span></a>
		</li>
		<li class="pc-item"><a href="listado_promotores.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Actualizar promotor</span></a>
		</li>
		<li class="pc-item"><a href="consulta_promotores.php" class="pc-link ">
		    <span class="pc-micon"><i data-feather="list"></i></span>
		    <span class="pc-mtext">Consultas de asistentes por promotor</span></a>
		</li>


	<?php } ?>

</ul>