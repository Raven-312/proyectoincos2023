@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-3">
                <h3>Lista de proveedores</h3>
            </div>
            <div class="col-md-5 text-center">
                <label>Datos repartidos en {{ $list->lastPage() }} sección(es)</label>
                <nav aria-label="Page navigation example ">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="{{ $list->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">«</span></a>
                        </li>
                        @for($i=1;$i<=$list->lastPage();$i++)
                            @if($i == $list->currentPage())
                                <li class="page-item active"><a class="page-link" href="{{ $list->url($i) }}">{{ $i }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $list->url($i) }}">{{ $i }}</a></li>
                            @endif
                            @if($list->lastPage()>10 && $i == 4)
                                @php $i = $list->lastPage()-4 @endphp
                                <li class="page-item"><a class="page-link">...</a></li>
                            @endif
                        @endfor
                        <li class="page-item">
                            <a class="page-link" href="{{ $list->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">»</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('supplier.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    <span class="text">Nuevo Proveedor</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4"> <!-- Tarjeta -->
            <div class="card-header py-3"> <!-- Cabecera de la tarjeta -->
                <h5><i class="fas fa-folder-tree"></i> Busqueda Global</h5>
            </div>
                <!-- Aqui esta todo el contenido de la pagina -->
            <div class="card-body">
                <div class="row">
                    @csrf
                    <div class="col-md-3 row">
                        <div class="col-4">
                            <label for="ciSupplier"><h5>CI/NIT:<h5></label>
                        </div>
                        <div class="col-8 mb-2">
                            <input type="text" class="form-control" id="ciSupplier" autofocus>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                        <button class="btn btn-warning" type="button" id="btnSearch">
                            <i class="fas fa-search"></i>
                            <span class="text">Buscar</span>
                        </button>
                    </div>
                    <div class="col-md-4 row">
                        <div class="col-4">
                            <label><h5>Proveedor:</h5></label>
                        </div>
                        <div class="col-8 mb-2">
                            <input type="text" class="form-control" id="fullnameSupplier" name="" readonly>
                            <input type="text" class="form-control" id="inputIDSupplier" name="" hidden>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <a id="btnGlobalBuy" class="btn btn-info" href="#">
                            <i class="fas fa-boxes-packing"></i>
                            <span class="text">Comprar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card shadow"> <!-- Tarjeta -->
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example2" width="100%">
                        <thead>
                            <tr>
                                <th>CI / NIT</i></th>
                                <th>Nombre Completo</th>
                                <th>Comprar</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $row)
                            <tr>
                                <td>{{ $row->CI }}</td>
                                <td>{{ $row->nombres.' '.$row->apellidos }}</td>
                                <td class="text-center">
                                    @if(verificarEstado($row->estado))
                                    <a href="{{ route('buy.index',$row->ID) }}" type="button" class="btn btn-square-50 btn-info">
                                        <i class="fas fa-boxes-packing"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('buy.index',$row->ID) }}" type="button" class="btn btn-square-50 btn-danger">
                                        <i class="fas fa-shop-slash"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('supplier.edit',$row->ID) }}" type="button" class="btn btn-square-45 btn-secondary">
                                        <i class="fas fa-pen-clip"> </i>
                                    </a>
                                    <form id="formStatus{{$row->ID}}" action="{{ route('supplier.destroy',$row->ID) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        @if(verificarEstado($row->estado))
                                        <button type="button" class="btn btn-square-40 btn-danger" onclick="auxStatus({{$row->ID}})" data-bs-toggle="modal" data-bs-target="#modalStatus" hidden>
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-square-45 btn-success" onclick="auxStatus({{$row->ID}})" data-bs-toggle="modal" data-bs-target="#modalStatus" hidden>
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- Aqui termina todo el contenido de la pagina -->
<!-- Modal para borrar -->
<div class="modal fade" id="modalStatus" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body">¿Esta seguro de modificar el estado del Proveedor?</h4>
                <label>Se cambiara el estado del proveedor seleccionado</label>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No (Cancelar)</button>
                <button id="statusTrue" class="btn btn-success" type="button">Si (Aceptar)</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <!-- Plugins para tablas -->
    <script src="{{ asset('template/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('template/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('template/js/table-datatable.js') }}"></script>
    <link href="{{ asset('template/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"/>
    <script>
        let status = 0;
        document.getElementById('statusTrue').onclick = function(){
            document.getElementById('formStatus'+status).submit();
        };
        function auxStatus(id){
            status = id;
        }
        document.getElementById('btnSearch').onclick = function(){
            let token = $('input[name=_token]').val();
            let ci = document.getElementById('ciSupplier').value;
            if(ci == ""){
                return ;
            }
            $.ajax({
            url: "{{ route('searchSupplier') }}",
            type:'post',
            data: {
                _token:token,
                ci:ci,
            },success: function (response) {
                let res = JSON.parse(response);
                if(res.length>0){
                    document.getElementById('fullnameSupplier').value = res[0].nombres+" "+res[0].apellidos;
                    document.getElementById('inputIDSupplier').value = res[0].ID;
                    document.getElementById('btnGlobalBuy').setAttribute('href','buy/'+res[0].ID);
                }else{
                    document.getElementById('fullnameSupplier').value = "No encontrado!!!";
                }
            },statusCode: {
                404: function() { alert('WEB NO ENCONTRADA'); }
            },});
        }
    </script>
@endsection
