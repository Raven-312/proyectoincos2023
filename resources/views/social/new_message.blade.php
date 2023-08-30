@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3>Enviar Mensaje</h3>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3"> <!-- Cabecera de la tarjeta -->
                        <h5>Aqui podra redactar un mensaje para el usuario seleccionado</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formMessage" action="{{ route('message.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-envelope"></i> Mensaje:</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>De:</b> {{ $from->nombres.' '.$from->apellidos }}</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <h6><b>Para:</b> {{ $to->nombres.' '.$to->apellidos }}</h6>
                                        <input type="hidden" name="to" value="{{ $to->ID }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Asunto:</h6>
                                        <input type="text" class="form-control" name="subject" placeholder="Describa el asunto" value="{{ old('subject') }}">
                                        @error('subject')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <br>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Relevancia:</h6>
                                        <select class="form-select" name="important">
                                            <option value="0">Mensaje</option>
                                            <option value="1">Notificación</option>
                                        </select>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Mensaje:</h6>
                                        <textarea class="form-control" name="message" placeholder="Escriba el mensaje">{{ old('message') }}</textarea>
                                        @error('message')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>Maximo 255 caracteres</small>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5><i class="fas fa-fingerprint"></i> Confirmación:</h5>
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6>Contraseña del Administrador:</h6>
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>Se requiere su contraseña</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 mb-3 text-center">
                                    <button class="btn btn-primary" id="btnSave" type="button" data-bs-toggle="modal" data-bs-target="#modalSave">
                                        <i class="fas fa-paper-plane"></i> Enviar
                                    </button>&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-secondary" type="reset">
                                        <i class="fas fa-brush"></i> Limpiar
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
                <h4 class="modal-body text-primary">¿Está seguro de crear mensaje?</h4>
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
        document.getElementById('formMessage').submit();
    }
</script>
@endsection