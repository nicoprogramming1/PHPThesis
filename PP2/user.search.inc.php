<ul class="list-unstyled">
					<li class="dropdown pc-h-item">
						<a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<i data-feather="search"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right pc-h-dropdown drp-search">
							<form class="px-3">
								<div class="form-group mb-0 d-flex align-items-center">
									<i data-feather="search"></i>
									<input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
								</div>
							</form>
						</div>
					</li>
					<li class="dropdown pc-h-item">
						<a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<span>
								<span class="user-name">
									<?php echo $_SESSION['Usuario_Nombre'].' '.$_SESSION['Usuario_Apellido']; ?>
								</span>
								<span class="user-desc">
									<?php echo $_SESSION['Usuario_Rol']; ?>
								</span>
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
							<div class=" dropdown-header">
								<h6 class="text-overflow m-0">Bienvenido!</h6>
							</div>
							<a href="#!" class="dropdown-item">
								<i data-feather="user"></i>
								<span>Mis Datos</span>
							</a>							
							<a href="cerrarsesion.php" class="dropdown-item">
								<i data-feather="power"></i>
								<span>Cerrar sesión</span>
							</a>
						</div>
					</li>
				</ul>