@@extends('general.main')
@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-inner">
                <div class="page-breadcrumb">
                    <ol class="breadcrumb container">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Actualizar</a></li>
                    </ol>
                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>Actualizar mis datos</h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Aqui podra modificar sus datos en la cuenta</h4>
                                </div>
                                <div class="panel-body">
                                <form id="formUser" action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                        {{ method_field('PATCH') }}
                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombres">Nombres:</label>
                                            <input type="text" class="form-control" placeholder="Nombres" name="nombre" value="{{ $user->nombre }}">
                                            @error('nombre')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apellidos">Apellido Paterno</label>
                                            <input type="text" class="form-control" placeholder="Apellido" name="apellido" value="{{ $user->apellido }}">
                                            @error('apellido')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apellidos">Apellido Materno</label>
                                            <input type="text" class="form-control" placeholder="Apellido" name="apellido2" value="{{ $user->apellido2 }}">
                                          
                                        </div>
                                        </div>
                                        <br>
                                <div class="row">
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ci">Documento de identidad:</label>
                                            <input type="text" class="form-control" name="ci" value="{{ $user->ci }}" readonly>
                                            @error('ci')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Numero de Contacto:</label>
                                            <input type="text" class="form-control" name="telefono" value="{{ $user->telefono }}">
                                            @error('telefono')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo">Correo electrónico:</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" require="false">
                                            @error('email')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <br>
                                <div class="row">
                                <div class="col-md-2">
                                <div class="form-group">
                                            <label for="foto">Foto de perfil:</label>
                                            <input type="file" class="form-control form-control-sm" name="foto" accept=".jpg, .png, .jpeg">
                                            @error('photo')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                        <br>
                                        <small>Archivos permitidos: (JPG, JPEG ,PNG)</small>
                                        <br>
                                        <small>(Recomendado) Aspecto cuadrado</small>
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="correo">Nombre de Usuario:</label>
                                            <input type="text" class="form-control" name="login" value="{{ $user->login }}">
                                            @error('username')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo">Nueva Contraseña:</label>
                                            <input type="password" class="form-control" name="password">
                                            @error('password')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ translatePassErrors("password",$message) }}</div>
										</div>
                                        @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="correo">Repita la Contraseña:</label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                            
                                        
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                </div><!-- Main Wrapper -->
                
            </div><!-- Page Inner -->
<!-- Aqui termina todo el contenido de la pagina -->
<div class="modal fade" id="modalUpdate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body text-primary">¿Está seguro de modificar sus datos?</h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No (Cancelar)</button>
                <button id="saveTrue" class="btn btn-success" type="button">Si (Aceptar)</a>
            </div>
        </div>
    </div>
</div>
@if(Session::has('success'))
<button class="btn btn-primary" id="btnSuccess" type="button" data-bs-toggle="modal" data-bs-target="#modalSuccess" hidden></button>
<div class="modal fade" id="modalSuccess" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-thumbs-up"></i> Exito</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-0">
                <h4 class="modal-body text-success">{{ Session::get('success') }}</h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
    @if(Session::has('success'))
        $(document).ready(function()
        {
            $("#btnSuccess").click();
        });
    @endif
    document.getElementById('saveTrue').onclick = function(){
        document.getElementById('formUser').submit();
    }
</script>
@endsection