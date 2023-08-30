@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6"> <h3>Nuevo Movimiento</h3> </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('movement.index') }}" class="btn btn-dark"><i class="fas fa-money-bill-1-wave"></i> Ver Movimientos</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3 "> <!-- Cabecera de la tarjeta -->
                        <h5>Llenar nuevo movimiento de caja (Entradas, Salidas)</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formMovement" action="{{ route('movement.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-money-bill-1-wave"></i> Movimiento:</h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h6>Monto (Bs):</h6>
                                        <input type="number" class="form-control" id="amount" name="amount" max="9999999" min="0" step="0.5" value="0">
                                        @error('amount')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-7">
                                        <h6>Descripción:</h6>
                                        <input class="form-control" name="description" value="{{ old('description') }}">
                                        @error('description')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Tipo:</h6>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text btn-success" for="type"><i class="fas fa-repeat"></i></label>
                                            <select class="form-select" name="type">
                                                <option value="0" selected="">Entrada</option>
                                                <option value="1">Salida</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6>Caja:</h6>
                                        <select type="text" class="form-select" name="cash" id="cash">
                                            @foreach($list as $row)
                                            <option value="{{ $row->ID }}">{{ $row->codigo.' ('.$row->nombre.')' }}</option>
                                            @endforeach
                                        </select>
                                        <small>(Seleccionar caja)</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Efectivo en caja (Bs):</h6>
                                        <select type="text" class="form-control" id="effective" readonly>
                                            @foreach($list as $row)
                                            <option value="{{ $row->ID }}">{{ number_format($row->efectivo,2) }}</option>
                                            @endforeach
                                        </select>
                                        <small>(Efectivo actual)</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Retiro de caja (Bs):</h6>
                                        <button type="button" id="retirar" class="btn btn-warning" onclick="retirar">Retirar todo</button>
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
                        <form id="formRetirar" action="{{ route('movement.empty') }}" method="POST" enctype="multipart/form-data">@csrf</form>
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
                <h4 class="modal-body text-primary">¿Está seguro realizar este movimiento?</h4>
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
        document.getElementById('formMovement').submit();
    }
    document.getElementById('cash').onchange = function(){
        let aux = document.getElementById('cash').value;
        document.getElementById('effective').value = aux;
    }
    document.getElementById("retirar").onclick = function(){
        let form = document.getElementById("formRetirar");
        form.append(document.getElementById("cash"));
        form.submit();
    }
</script>
@endsection