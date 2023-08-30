@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6">
                <h3>Ventas</h3>
            </div>
            <div class="col-md-6 text-end">
                <a type="button" class="btn btn-dark" href="{{ url()->previous() }}">
                    <i class="fas fa-backward"></i>Cancelar
                </a>
            </div>
        </div>
        <div class="card border-left-primary shadow"> <!-- Tarjeta -->
            <div class="card-header py-3 text-center"> <!-- Cabecera de la tarjeta -->
                <div class="row">
                    <div class="col-md-1 text-center"> <label for="venIDAgregar"><b>Código Producto:</b></label> </div>
                    <div class="col-md-2 text-center mb-2">
                        <input type="text" id="venIDAgregar" class="form-control" autofocus>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <button id="venButtonAgregar" class="btn btn-square-45 btn-success" hidden>
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" hidden data-bs-target="#agregarProductosVenta">
                            <i class="fas fa-search"></i>Buscar
                        </button>
                    </div>
                    <div class="col-md-2 text-center">      
                        <h6><b>Caja:</b> {{ $cash->codigo.' ('.$cash->nombre.')' }}</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="input-group mb-3">
                            <label class="input-group-text btn-secondary" for="impuesto"><i class="fas fa-file-invoice"></i></label>
                            <select class="form-select" id="impuesto" name="impuesto">
                                <option value="0" selected>Recibo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="input-group mb-3">
                            <label class="input-group-text btn-primary" for="transaction"><i class="fas fa-money-bill-wave"></i></label>
                            <select class="form-select" name="transaction" id="transaction">
                                <option value="0" selected>Efectivo</option>
                                <option value="1">Transferencia</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-header"> <h6><b>DATOS GENERALES</b></h6> </div>
                        <!-- Cuerpo de datos del cliente -->
                        <div class="col-md-12 card">
                            <div class="row">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class='row col-md-7'>
                                    <b>Cliente:</b>
                                    <input type="hidden" value="{{ $client->ID }}" id="venIDCliente" name="IDCli">
                                    <input type="text" class="form-control form-control-user" name="cliente" value="{{ $client->nombres.' '.$client->apellidos }}" disabled>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class='row col-md-5'>
                                    <b>CI / NIT:</b>
                                    <input type="text" class="form-control form-control-user" name="ci" value="{{ $client->CI }}" disabled>
                                </div>
                            </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-7'>
                                <b>Vendedor:</b>
                                <input type="text" class="form-control form-control-user" name="vendedor" required value="{{ $user->nombres.' '.$user->apellidos }}" disabled>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-5'>
                                <b>Sucursal:</b>
                                <input type="text" class="form-control form-control-user" name="sucursal" required value="Colomi" disabled>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-header"> <h6><b>VENTA</b></h6> </div>
                        <div class="col-md-12 card">
                            <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>N° Venta:</b>
                                <input type="text" class="form-control form-control-user" id="venNro" name="nro" value="{{ $sale+1 }}" readonly>
                                @error('nro')
                                <div class="alert alert-danger border-0 py-0 bg-danger">
                                    <div class="text-white">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>Productos:</b>
                                <input type="text" id="venTotalPro" class="form-control form-control-user" name="cantidad" value="0" required readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>Fecha y Hora:</b>
                                <input type="text" class="form-control text-end" name="fecha" value="<?php echo formatoFechaHoraVista(now()); ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Botellas:</b>
                                <input type="text" id="venBot" class="form-control" name="bottle" value="0" required>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Deuda:</b>
                                <input type="number" id="venDebt" class="form-control" name="debt" value="0" required readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Pago:</b>
                                <input type="number" id="venPay" class="form-control" name="pay" value="0" required min="0" onchange="calibrarPago()" onkeyup="calibrarPago()">
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b style="color:red;">Total:</b>
                                <br>
                                <input style="color: red; font-weight: bold;" type="number" id="venTotalPag" class="form-control form-control-user text-end" value="0" name="total" required readonly>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <form action="{{ route('sale.store') }}" method="POST" id="formVentas" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"> <h6><b>DETALLE</b></h6> </div>
                            <div class="col-md-6 text-end">
                                <button type="button" id="generarVenta" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalSure">
                                    <i class="fas fa-square-plus"></i>Generar Venta
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 card">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaDetalleVenta" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Precio (Bs)</th>
                                        <th>Subtotal (Bs)</th>
                                        <th><i class="fas fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <input type="hidden" id="ventaCodigos" name="codigos">
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Buscar Nuevo Producto -->
<div class="modal fade" id="agregarProductosVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-search"></i> Buscar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" width="100%" id="tablaproductos" cellspacing="3">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Marca</th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    @foreach($products as $row)
                                    <tr>
                                        <td hidden>{{ $row->ID }}</td>
                                        <td>{{ $row->codigo }}</td>
                                        @if($row->modelo == Null)
                                        <td>{{ $row->nombre.' - '.$row->unidad }}</td>
                                        @else
                                        <td>{{ $row->nombre.' - '.$row->unidad.' ('.$row->modelo.')' }}</td>
                                        @endif
                                        <td>{{ $row->marca }}</td>
                                        <td hidden>{{ $row->precio }}</td>
                                        <td hidden>{{ $row->botellas }}</td>
                                        <td hidden>{{ $row->almacen }}</td>
                                        <td hidden>{{ $row->modelo }}</td>
                                        <td class="text-center"> <button class="btn btn-square-45 btn-primary" onclick="agregarVenta(<?php echo $row->ID ?>)"> <i class="fas fa-plus"></i> </button> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button data-bs-dismiss="modal" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSure" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h2><i class="fas fa-circle-question"></i> Genesis-Lite</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<h4 class="modal-body text-primary">¿Esta seguro de Realizar esta operación?</h4>
                <label id="errors">Se le mostrara una vista previa</label>
			</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No (Cancelar)</button>
                <button id="saveTrue" class="btn btn-success" type="button">Si (Aceptar)</a>
            </div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
    <script>
        function calibrarPago(){
            let tot = document.getElementById('venTotalPag').value;
            let pay = document.getElementById('venPay').value;
            let res = tot - pay;
            document.getElementById('venDebt').value = res;
        }
    </script>
    <!-- Javascript extras -->
    <script src="{{ asset('template/js/extras/functionsSale.js') }}"></script>
    <!-- Plugins para tablas -->
    <script src="{{ asset('template/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('template/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('template/js/table-datatable.js') }}"></script>
    <link href="{{ asset('template/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection