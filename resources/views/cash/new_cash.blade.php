@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6"> <h3>Nueva Caja</h3> </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('cash.index') }}" class="btn btn-dark"><i class="fas fa-cash-register"></i> Ver Cajas</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3 "> <!-- Cabecera de la tarjeta -->
                        <h5>Llene los datos de una nueva caja</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formCash" action="{{ route('cash.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-cash-register"></i> Caja:</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Codigo de caja:</h6>
                                        <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                        @error('code')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>(Letras Mayúsculas)</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Alias de caja:</h6>
                                        <input type="text" class="form-control" name="alias" value="{{ old('alias') }}">
                                        @error('alias')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Efectivo:</h6>
                                        <input type="number" class="form-control" name="effective" value="0" max="1000000" min="0" step="0.5">
                                        @error('effective')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" id="btnSave" type="button" data-bs-toggle="modal" data-bs-target="#modalSave">
                                        <i class="fas fa-save"></i>Guardar
                                    </button>&nbsp;&nbsp;&nbsp;
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
                <h4 class="modal-body text-primary">¿Esta seguro de agregar una nueva Caja?</h4>
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
        document.getElementById('formCash').submit();
    }
</script>
@endsection