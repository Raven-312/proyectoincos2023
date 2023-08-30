

@section('topbar')
<!-- Aqui esta la barra de navegacion superior -->
 <header>
	<div class="topbar d-flex align-items-center">
		<nav class="navbar navbar-expand">
			<div class="mobile-toggle-menu"><i class='fas fa-bars'></i></div>
			<div class="top-menu ms-auto">
				<ul class="navbar-nav align-items-center">
					<li class="nav-item dropdown dropdown-large">
						<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span id="countAlerts"></span>
							<i class='fas fa-bell'></i>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a href="javascript:;">
								<div class="msg-header">
									<p class="msg-header-title">Notificaciones</p>
								</div>
							</a>
							<div class="header-notifications-list" id="dropdownAlerts"></div>
							<a href="{{ route('message.center') }}">
								<div class="text-center msg-footer">Centro de Alertas</div>
							</a>
						</div>
					</li>
					<li class="nav-item dropdown dropdown-large">
						<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span id="countMessages"></span>
							<i class='fas fa-comment'></i>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a href="javascript:;">
								<div class="msg-header">
									<p class="msg-header-title">Mensajes</p>
								</div>
							</a>
							<div class="header-message-list" id="dropdownMessages"></div>
							<a href="{{ route('message.center') }}">
								<div class="text-center msg-footer">Centro de Mensajeria</div>
							</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="user-box dropdown">
				<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<img id="imgProfileTopBar" src="{{ asset('storage/users/default_user.jpg') }}" class="user-img" alt="user avatar">
					<div class="user-info ps-3">
						<p class="user-name mb-0">{{ session('usernameSession') }}</p>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalProfile"><i class="fas fa-user"></i><span>Perfil</span></button></li>
					<li><div class="dropdown-divider mb-0"></div></li>
					<li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalLogout"><i class='fas fa-right-from-bracket'></i><span>Cerrar Sesión</span></button></li>
				</ul>
			</div>
		</nav>
	</div>
</header>

<div class="modal fade" id="modalLogout" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<h4>¿Esta seguro de Cerrar la Sesión Actual?</h4>
			</div>
			<div class="modal-footer">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No (Atras)</button>
				<button type="submit" class="btn btn-primary" href="{{ route('logout') }}">Si (Salir)</a>
                </form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalProfile" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Datos de la Sesión</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
            	<div class="text-center">
                	<img id="imgProfile" class="rounded-circle p-2 bg-info" src="{{ asset('storage/users/default_user.jpg') }}" width="200" height="200">
            	</div>    
            	<hr>
                @csrf
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <label><b>Nombre Completo: </b></label>
                    </div>
                    <div class="col-lg-8 text-left">
                        <label id="labelFullName"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <label><b>Nombre Usuario: </b></label>
                    </div>
                    <div class="col-lg-8 text-left">
                        <label id="labelUsername">{{ session('usernameSession') }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <label><b>Doc. Identidad: </b></label>
                    </div>
                    <div class="col-lg-8 text-left">
                        <label id="labelCI"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <label><b>N° Contacto: </b></label>
                    </div>
                    <div class="col-lg-8 text-left">
                        <label id="labelPhone"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <label><b>email: </b></label>
                    </div>
                    <div class="col-lg-8 text-left">
                        <label id="labelEmail"></label>
                    </div>
                </div>
            </div>
			<div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

@endsection





	
