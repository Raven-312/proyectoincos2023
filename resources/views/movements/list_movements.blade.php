@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-4">
                <h3>Registro de movimientos</h3>
            </div>
            <div class="col-md-4 text-center">
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
                <a href="{{ route('movement.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    <span class="text">Nuevo movimiento</span>
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <h6>Caja:</h6>
                <select type="text" class="form-select" name="cash" id="cash">
                    @foreach($list2 as $row)
                    <option value="{{ $row->ID }}">{{ $row->codigo.' ('.$row->nombre.')' }}</option>
                    @endforeach
                </select>
                <small>(Seleccionar caja)</small>
            </div>
            <div class="col-md-3">
                <h6>Efectivo en caja (Bs):</h6>
                <select type="text" class="form-control" id="effective" disabled>
                    @foreach($list2 as $row)
                    <option value="{{ $row->ID }}">{{ number_format($row->efectivo,2) }}</option>
                    @endforeach
                </select>
                <small>(Efectivo actual)</small>
            </div>
        </div>
        <div class="card shadow"> <!-- Tarjeta -->
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" width="100%" id="example2" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Caja</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $row)
                            <tr>
                                <td class="text-center">{{ $row->codigo.' ('.$row->nombre.')' }}</td>
                                <td class="text-center">{{ formatoMovimiento($row->tipo) }}</td>
                                <td class="text-end">{{ number_format($row->monto,2) }}</td>
                                <td>{{ $row->descripcion }}</td>
                                <td class="text-center">{{ formatoFechaHoraVista($row->fecha) }}</td>
                                <td class="text-center">{{ $row->nombres.' '.$row->apellidos }}</td>
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
@endsection
@section('scripts')
<script>
    document.getElementById('cash').onchange = function(){
        let aux = document.getElementById('cash').value;
        document.getElementById('effective').value = aux;
    }
</script>
<!-- Plugins para tablas -->
<script src="{{ asset('template/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('template/js/table-datatable.js') }}"></script>
<link href="{{ asset('template/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"/>
@endsection