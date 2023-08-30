@extends('general.main')
@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6"> <h3>Editar Producto</h3> </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('product.index') }}" class="btn btn-dark"><i class="fas fa-box"></i> Ver Productos</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3"> <!-- Cabecera de la tarjeta -->
                        <h5>Aqui podra modificar el formulario con los datos del producto seleccionado</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form id="formProduct" action="{{ route('product.update',$product->ID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                            <div>   
                                <h5><i class="fas fa-address-card"></i> Datos del producto:</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Codigo de producto:</h6>
                                        <input type="text" class="form-control" name="code" readonly value="{{ $product->codigo }}">
                                        @error('code')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Nombre:</h6>
                                        <input type="text" class="form-control" name="name" value="{{ $product->nombre }}">
                                        @error('name')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Marca:</h6>
                                        <input type="text" class="form-control" name="brand" value="{{ $product->marca }}">
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
                                        <input type="text" class="form-control" name="model" value="{{ $product->modelo }}">
                                        @error('model')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Presentación:</h6>
                                        <select class="form-select" name="unit">
                                            @php $units = ['Paquete','1/2 Paquete','Pack','Unidad','Caja','Otro']; @endphp
                                            @for($i=0;$i<count($units);$i++)
                                                @if($product->unidad == $units[$i])
                                                    <option value="{{ $units[$i] }}" selected>{{ $units[$i] }}</option>
                                                @else
                                                    <option value="{{ $units[$i] }}">{{ $units[$i] }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Precio:</h6>
                                        <input type="number" class="form-control" name="price" min="0" step="0.5" value="{{ $product->precio }}">
                                        @error('price')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Categoria:</h6>
                                        <select  class="form-select" id="category" name="category">
                                        @foreach($categories as $row)
                                            @if($row->ID == $product->categoria)
                                            <option value="{{ $row->ID }}" selected>{{ $row->nombre }}</option>
                                            @else
                                            <option value="{{ $row->ID }}">{{ $row->nombre }}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <h6>Actual:</h6>
                                        <img src="{{ asset('storage/'.$product->foto) }}" width="80" height="80" >
                                    </div>
                                    <div class="col-md-5 mb-3">
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
                                        <input type="number" class="form-control" name="bottle" value="{{$product->botellas}}" min="1">
                                        @error('bottle')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Almacen inicial:</h6>
                                        <input type="number" class="form-control" name="storage" value="{{$product->almacen}}" min="0">
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
                                <button class="btn btn-primary" id="btnSave" type="button" data-bs-toggle="modal" data-bs-target="#modalUpdate">
                                        <i class="fas fa-sync"></i> Actualizar datos
                                    </button>&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-secondary" type="reset">
                                        <i class="fas fa-pen-nib"></i> Restaurar
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
<div class="modal fade" id="modalUpdate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body text-primary">¿Está seguro de modificar datos del producto?</h4>
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
    $(document).ready(function(){
        document.getElementById('code').value = getRandomMinMax(1000000000,9999999999);
    });
    document.getElementById('saveTrue').onclick = function(){
        document.getElementById('formProduct').submit();
    }
</script>
@endsection