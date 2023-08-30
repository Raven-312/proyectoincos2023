@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6"> <h3>Nuevo Usuario</h3> </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('user.index') }}" class="btn btn-dark"><i class="fas fa-users"></i> Ver Usuarios</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3 "> <!-- Cabecera de la tarjeta -->
                        <h5>Llene los datos de un nuevo usuario</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formUser" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-address-card"></i> Datos Personales:</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Nombres:</h6>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        @error('name')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Apellidos:</h6>
                                        <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                                        @error('lastname')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Documento de Identidad:</h6>
                                        <input type="text" class="form-control" name="ci" value="{{ old('ci') }}">
                                        @error('ci')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Número de contacto:</h6>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Correo:</h6>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                        @error('email')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6>Foto:</h6>
                                        <input type="file" class="form-control-file" name="photo" accept=".jpg, .png, .jpeg">
                                        @error('photo')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                        <br>
                                        <small>Archivos permitidos: JPG, JPEG ,PNG (Aspecto cuadrado)</small>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <h5><i class="fas fa-chalkboard-user"></i> Cuenta:</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Nombre de usuario:</h6>
                                        <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                                        @error('username')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Contraseña:</h6>
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ translatePassErrors("password",$message) }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Repita la contraseña:</h6>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <h5><i class="fas fa-key"></i> Acceso a:</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Tipo de usuario:</h6>
                                            <select class="form-select" name="access">
                                                <option value="root">Super#</option>
                                                <option value="Vendedor" selected>Vendedor</option>
                                            </select>
                                        </div>
                                    <div class="col-md-4">
                                        <h6> Caja:</h6>
                                        <select class="form-select" name="cash">
                                            @foreach($list as $row)
                                                <option value="{{ $row->ID }}">{{ $row->code.' ('.$row->nombre.')' }}</option>
                                            @endforeach
                                        </select>
                                        <small>Elija una caja por defecto</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <button class="btn btn-primary" id="btnSave" type="button" data-bs-toggle="modal" data-bs-target="#modalSave">
                                        <i class="fas fa-save"></i>Guardar
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-secondary" type="reset">
                                        <i class="fas fa-brush"></i>Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Aqui termina todo el contenido de la pagina -->
<div class="modal fade" id="modalSave" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body text-primary">¿Está seguro de agregar un nuevo Usuario?</h4>
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
        $(document).ready(function(){
            $("#btnSuccess").click();
        });
    @endif
    document.getElementById('saveTrue').onclick = function(){
        document.getElementById('formUser').submit();
    }
</script>
@endsection