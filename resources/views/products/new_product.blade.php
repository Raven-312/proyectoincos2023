@extends('layouts.main')
@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-inner">
        <div class="page-breadcrumb">
                    <ol class="breadcrumb container">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Materiales</li>
                    </ol>
                </div>
                <div class="page-title ">
                    <div class="container">
                        <h3>LLene los datos de un Nuevo material</h3>
                       <br>
                            <button id="btnGenerate" type="button" class="btn btn-warning"> <i class="fa fa-barcode"></i> Generar codigo aleatorio</button>
                       
                    </div>
                    
                </div>
                <div id="main-wrapper" class="container">
                <div class="col-md-14">
                            <div class="panel panel-white">
  
                                        <form id="wizardForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                        
                                <br>
                                <div class="form-group col-md-2">
                                         <label for="codigodeprod">Codigo de Rollo</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo">
                                        @error('codigo')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>- 10 dígitos generado aleatorio<br>- 13 dígitos manual</small>
                                    </div>
                                    <div class="col-md-3">
                                    <label for="nombre">Nombre del Material</label>
                                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                                        @error('nombre')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                    <label for="nombre">Marca:</label>
                                        <input type="text" class="form-control" name="marca" value="{{ old('marca') }}">
                                        @error('marca')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                    <label for="modelo">Modelo:</label>
                                        <input type="text" class="form-control" name="modelo" value="{{ old('modelo') }}">
                                        @error('modelo')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>*Opcional</small>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-md-3">
                                 

                                 
                                    <label for="presentacion">Presentacion</label>
                                        @php $units = ['Rollo','Lamina','Hoja','Caja','Tambor','Otro']; @endphp
                                        <select class="form-select" name="unit">
                                            @for($i=0;$i<count($units);$i++)
                                                <option value="{{ $units[$i] }}">{{ $units[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="precio">Precio de Venta</label>
                                        <input type="number" class="form-control" name="precio" value="0" min="0" step="0.5">
                                        @error('precio')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                    <br>
                                     <br>
                                    <label for="categoria">Categoria</label>
                                        <select  class="form-select" name="categoria">
                                        @foreach($list as $row)
                                            <option value="{{ $row->id }}">{{ $row->nombre }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-md-3">
                                  
                                    <label for="foto">Foto</label>
                                        <input type="file" class="form-control-file" name="foto" accept=".jpg, .png, .jpeg">
                                        @error('foto')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <small>Archivos permitidos: JPG, JPGE ,PNG</small>
                                        <br>
                                        <small>*Opcional</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                  
                                    <label for="metros">Metros</label>
                                        <input type="number" class="form-control" name="longitud" value="1" min="1">
                                        @error('longitud')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                    <label for="almacen">Almacen Inicial</label>
                                        <input type="number" class="form-control" name="cantidad" value="0" min="0">
                                        @error('cantidad')
										<div class="alert alert-danger border-0 py-0 bg-danger">
											<div class="text-white">{{ $message }}</div>
										</div>
                                        @enderror
                                        <br>
                                      <br>
                                     <br>
                                    </div>
                                </div>
                            </div>
                         
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 mb-3 text-center">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-sm">Guardar</button>
                                <button type="cancel" class="btn btn-danger">Limpiar</button>
                            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <h4 class="modal-title" id="mySmallModalLabel">Agregar Nuevo material</h4>
                                     </div>
                              <div class="modal-body">
                                     Se va guardar este material
                                 </div>
                                  <div class="modal-footer">
                                       <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">No (cancelar)</button>
                                          <button type="submit" class="btn btn-success"  onclick="registrarUsuario()">Si (Aceptar)</button>
                                         </div>
                                             </div>
                                                </div>
                            </div>
                                </div>
                            </div>
                        </form>
           
                           
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
                <h2><i class="fas fa-circle-question"></i> Textiles Nueva York</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body text-primary">¿Está seguro de agregar un nuevo Producto?</h4>            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No (Cancelar)</button>
                <button id="saveTrue" class="btn btn-success" type="submit">Si (Aceptar)</a>
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
    let code = document.getElementById('codigo');
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
        document.getElementById('codigo').value = getRandomMinMax(1000000000,9999999999);
        validateCode();
    });
    function getRandomMinMax(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
</script>
@endsection