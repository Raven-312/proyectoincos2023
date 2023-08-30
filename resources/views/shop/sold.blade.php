@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3> <i class="fas fa-eye"></i> Visualizar Venta</h3>
        <div class="card border-left-primary shadow"> <!-- Tarjeta -->
            <div class="card-header py-3 text-center"> <!-- Cabecera de la tarjeta -->
                <div class="row">
                    <div class="col-md-3 text-center mb-2">
                        <a type="submit" hidden class="btn btn-warning" href="{{ route('sale.print',$id) }}" target="_blank">
                            <i class="fas fa-file-invoice"></i> Imprimir Recibo
                        </a>
                        <a type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bottleModal">
                            <i class="fas fa-wine-bottle"></i> Ver botellas
                        </a>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="submit" class="btn btn-info" href="{{ route('sale.print80',$id) }}" target="_blank">
                            <i class="fas fa-receipt"></i> Imprimir Ticket
                        </a>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="button" class="btn btn-success" href="{{ route('client.index') }}">
                            <i class="fas fa-cart-shopping"></i> Ventas 
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="card-header"> <h6><b>DATOS GENERALES</b></h6> </div>
                        <!-- Cuerpo de datos del cliente -->
                        <div class="col-md-12 card">
                            <div class="row">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class='row col-md-7'>
                                    <b>Cliente:</b>
                                    <input type="text" class="form-control form-control-user" name="cliente" value="@foreach($sale as $row) {{$row->nomC.' '.$row->apeC}} @endforeach" disabled>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class='row col-md-5'>
                                    <b>CI / NIT:</b>
                                    <input type="text" class="form-control form-control-user" name="ci" value="@foreach($sale as $row) {{$row->CI}} @endforeach" disabled>
                                </div>
                            </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-7'>
                                <b>Vendedor:</b>
                                <input type="text" class="form-control form-control-user" name="vendedor" required value="@foreach($sale as $row) {{$row->nombres.' '.$row->apellidos}} @endforeach" disabled>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-5'>
                                <b>Sucursal:</b>
                                <input type="text" class="form-control form-control-user" name="sucursal" required value="Central" disabled>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4"> <h6><b>VENTA</b></h6> </div>
                            <div class="col-md-4 text-end" style="color: green">
                                @foreach($sale as $row) 
                                    @if($row->impuesto == 1)
                                        "Esta Venta esta Facturada"
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 card">
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3 mb-3 mb-md-0'>
                                <b>N° Venta:</b>
                                <input type="text" class="form-control form-control-user text-end" id="venNro" name="nro" value="@foreach($sale as $row) {{$row->ID}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3 mb-3 mb-md-0'>
                                <b>Productos:</b>
                                <input type="text" id="venTotalPro" class="form-control form-control-user text-end" name="cantidad" value="@foreach($sale as $row) {{$row->cantidad}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-2 mb-2 mb-md-0'>
                                <b>Botellas:</b>
                                <input type="text" id="venBotellas" class="form-control form-control-user" name="botellas" value="@foreach($sale as $row) {{$row->botellas}} @endforeach" disabled>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4 mb-3 mb-md-0'>
                                <b>Fecha y Hora:</b>
                                <input type="text" class="form-control form-control-user text-end" name="fecha" value="@foreach($sale as $row) {{formatoFechaHoraVista($row->fecha)}} @endforeach" disabled>
                            </div>
                            
                        </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Pagó:</b>
                                <input type="text" class="form-control form-control-user text-end" id="pago" name="pago" value="@foreach($sale as $row) {{number_format($row->pago,2)}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Debe:</b>
                                <input type="text" class="form-control form-control-user text-end" id="debe" name="debe" value="@foreach($sale as $row) {{number_format($row->deuda,2)}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b>Cobrar:</b>
                                <input type="number" class="form-control form-control-user" id="cobro" name="cobro" value="0" min="0" step="0.5">
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-3'>
                                <b style="color:red">Total (Bs):</b>
                                <br>
                                <input style="color:red; font-weight:bold;" type="text" id="venTotalPag" class="form-control form-control-user text-end" name="total" value="@foreach($sale as $row) {{number_format($row->total,2)}} @endforeach" readonly>
                            </div>
                        </div>
                        <form action="{{ route('sale.debt')}}" method="POST" id="formDeudas" enctype="multipart/form-data"> @csrf </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header"> 
                        <div class="row">
                            <div class="col-md-6"> <h6><b>DETALLE</b></h6> </div>
                            <div class="col-md-6 text-end">
                                <button type="button" id="pagarDeuda" class="btn btn-warning" onclick="enviarFormularioVenta()">
                                    <i class="fas fa-money-bills"></i>Pagar deuda
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 card">
                        <div class="table-responsive table-wrapper">
                            <table class="table table-bordered" id="tablaDetalleVenta" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Glosa</th>
                                        <th>Cantidad</th>
                                        <th>Precio (Bs)</th>
                                        <th>Subtotal (Bs)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $num = 1; ?>
                                    @foreach($detail as $row)
                                    <tr>
                                        <td>{{$num}}</td>
                                        <td>{{$row->codigo}}</td>
                                        @if($row->modelo == Null)
                                        <td>{{ $row->nombre.' - '.$row->unidad }}</td>
                                        @else
                                        <td>{{ $row->nombre.' - '.$row->unidad.' ('.$row->modelo.')' }}</td>
                                        @endif
                                        <td>{{$row->glosa}}</td>
                                        <td class="text-end">{{$row->cantidad}}</td>
                                        <td class="text-end">{{number_format($row->precio,2)}}</td>
                                        <td class="text-end">{{number_format($row->subtotal,2)}}</td>
                                    </tr>
                                    <?php $num++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="button" class="btn btn-danger" href="{{ route('sale.destroy',$id) }}">
                            <i class="fas fa-xmark"></i> Anular Venta 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bottleModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Botellas Prestadas</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
            <form action="{{ route('report.bottles') }}" method="POST" enctype="multipart/form-data">
                <div class="row col-xl-6 mx-auto">
                    @csrf
                    <b>Botellas Prestadas:</b>
                    <input type="hidden" name="nroVenta" value="{{$id}}">
                    <input type="text" class="form-control" value="@foreach($sale as $row) {{$row->botellas}} @endforeach" disabled>
                </div>
                <br>
                <div class="row col-xl-6 mx-auto">
                    <b>Botellas devueltas:</b>
                    <input type="number" class="form-control" name="botellas" value="0">
                </div>
                <br>
                <div class="row col-xl-3 mx-auto">
                    <b>Cobrar (Bs):</b>
                    <input type="number" class="form-control" name="pago" value="0" step="0.5" min="0">
                </div>
            </div>
			<div class="modal-footer">
                <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Cobrar</button>
            </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script>
    let formularioVenta = document.getElementById('formDeudas');
    function enviarFormularioVenta(){
        formularioVenta.append(document.getElementById('pago'));
        formularioVenta.append(document.getElementById('debe'));
        formularioVenta.append(document.getElementById('cobro'));
        formularioVenta.append(document.getElementById('venTotalPag'));
        formularioVenta.append(document.getElementById('venNro'));
        formularioVenta.submit();
    }
</script>
@endsection