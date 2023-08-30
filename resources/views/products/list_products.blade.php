@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-3">
                <h3>Lista de productos</h3>
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
            <div class="col-md-4 text-end mb-2">
                <a hidden href="{{ route('report.catalog') }}" class="btn btn-warning" target="_blank">
                    <i class="fas fa-barcode"></i>
                    <span class="text">Imprimir Catalogo</span>
                </a>
                <a href="{{ route('product.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    <span class="text">Nuevo Producto</span>
                </a>
            </div>
        </div>
        <hr>
        <div class="card shadow"> <!-- Tarjeta -->
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" width="100%" id="example2" cellspacing="3">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Presentación</th>
                                <th>Precio</th>
                                <th>Foto</th>
                                <th>Categoría</th>
                                <th>Botellas</th>
                                <th>Stock</th>
                                <th>Imprimir</th>
                                <th>Editar</th>
                                <th>Hab/Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $row)
                            <tr>
                                <td>{{ $row->codigo }}</td>
                                <td>{{ $row->nombre }}</td>
                                <td>{{ $row->marca }}</td>
                                <td>{{ $row->modelo }}</td>
                                <td>{{ $row->unidad }}</td>
                                <td>{{ number_format($row->precio,2) }}</td>
                                <td><img src="{{ asset('storage/'.$row->foto) }}" height="50" width="50"></td>
                                <td>{{ $row->categoria }}</td>
                                <td>{{ $row->botellas }}</td>
                                <td>{{ $row->almacen }}</td>
                                <td  class="text-center">
                                    @if(verificarEstado($row->estado))
                                    <a href="{{ route('product.show',$row->ID) }}" target="_blank" class="btn btn-square-45 btn-info">
                                        <i class="fas fa-barcode"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('product.show',$row->ID) }}" class="btn btn-square-45 btn-danger">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('product.edit',$row->ID) }}" type="button" class="btn btn-square-45 btn-secondary">
                                        <i class="fas fa-pen-clip"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form id="formStatus{{$row->ID}}" action="{{ route('product.destroy',$row->ID) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        @if(verificarEstado($row->estado))
                                        <button type="button" class="btn btn-square-40 btn-danger" onclick="auxStatus({{$row->ID}})" data-bs-toggle="modal" data-bs-target="#modalStatus">
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-square-45 btn-success" onclick="auxStatus({{$row->ID}})" data-bs-toggle="modal" data-bs-target="#modalStatus">
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
<div class="modal fade" id="modalStatus" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body">¿Está seguro de modificar el estado del Producto?</h4>
                <label>Se cambiara el estado del producto seleccionada</label>
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
</script>
@endsection