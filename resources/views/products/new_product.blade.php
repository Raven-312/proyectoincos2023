@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6"> <h3>Nuevo Producto</h3> </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('product.index') }}" class="btn btn-dark"><i class="fas fa-box"></i> Ver Productos</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3 row"> <!-- Cabecera de la tarjeta -->
                        <div class="col-md-6">
                            <h5>Llene los datos de un nuevo Producto</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <button id="btnGenerate" type="button" class="btn btn-warning"> <i class="fas fa-barcode"></i> Generar aleatorio</button>
                        </div>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formProduct" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-basket-shopping"></i> Datos del producto:</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Codigo de producto:</h6>
                                        <input type="text" class="form-control" id="code" name="code">
                                        @error('code')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>- 10 dígitos generado aleatorio<br>- 13 dígitos manual</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Nombre del producto:</h6>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        @error('name')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Marca:</h6>
                                        <input type="text" class="form-control" name="brand" value="{{ old('brand') }}">
                                        @error('brand')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6>Modelo:</h6>
                                        <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                                        @error('model')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Presentación:</h6>
                                        @php $units = ['Paquete','1/2 Paquete','Pack','Unidad','Caja','Otro']; @endphp
                                        <select class="form-select" name="unit">
                                            @for($i=0;$i<count($units);$i++)
                                                <option value="{{ $units[$i] }}">{{ $units[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Precio Venta:</h6>
                                        <input type="number" class="form-control" name="price" value="0" min="0" step="0.5">
                                        @error('price')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Categoría:</h6>
                                        <select  class="form-select" name="category">
                                        @foreach($list as $row)
                                            <option value="{{ $row->ID }}">{{ $row->nombre }}</option>
                                        @endforeach
                                        </select>
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
                                        <small>Archivos permitidos: JPG, JPGE ,PNG</small>
                                        <br>
                                        <small>*Opcional</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h6>Botellas:</h6>
                                        <input type="number" class="form-control" name="bottle" value="1" min="1">
                                        @error('bottle')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Almacen inicial:</h6>
                                        <input type="number" class="form-control" name="storage" value="0" min="0">
                                        @error('storage')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 mb-3 text-center">
                                    <button class="btn btn-primary" id="btnSave" type="button" data-bs-toggle="modal" data-bs-target="#modalSave">
                                        <i class="fas fa-save"></i> Guardar
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
                <h4 class="modal-body text-primary">¿Está seguro de agregar un nuevo Producto?</h4>            </div>
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
    let code = document.getElementById('code');
    document.getElementById('saveTrue').onclick = function(){
        if(code.value.length == 10 || code.value.length == 13){
            document.getElementById('formProduct').submit();
        }
    }
    $('#code').on('keyup', validateCode);
    function validateCode(){
        if(code.value.length == 10 || code.value.length == 13){ 
            code.removeAttribute('class');
            code.setAttribute('class','form-control is-valid');
        }else{
            code.removeAttribute('class');
            code.setAttribute('class','form-control is-invalid');
        }
    }
    $('#btnGenerate').click(function(){
        document.getElementById('code').value = getRandomMinMax(1000000000,9999999999);
        validateCode();
    });
    function getRandomMinMax(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
</script>
@endsection