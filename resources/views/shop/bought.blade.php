@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3> <i class="fas fa-eye"></i> Visualizar Compra</h3>
        <div class="card border-left-primary shadow"> <!-- Tarjeta -->
            <div class="card-header py-3 text-center"> <!-- Cabecera de la tarjeta -->
                <div class="row">
                    <div class="col-md-3 text-center mb-2">
                        <a type="submit" class="btn btn-warning" href="{{ route('buy.print',$id) }}" target="_blank">
                            <i class="fas fa-file-invoice"></i> Imprimir Comprobante
                        </a>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="submit" class="btn btn-info" href="{{ route('buy.print80',$id) }}" target="_blank">
                            <i class="fas fa-receipt"></i> Imprimir Ticket
                        </a>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="button" class="btn btn-success" href="{{ route('supplier.index') }}">
                            <i class="fas fa-cart-shopping"></i> Compras 
                        </a>
                    </div>
                    <div class="col-md-3 text-center mb-2">
                        <a type="button" class="btn btn-danger" href="#">
                            <i class="fas fa-xmark"></i> Anular Compra 
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-header"> <h6><b>DATOS GENERALES</b></h6> </div>
                        <!-- Cuerpo de datos del proveedor -->
                        <div class="col-md-12 card">
                            <div class="row">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class='row col-md-7'>
                                    <b>Proveedor:</b>
                                    <input type="text" class="form-control form-control-user" name="proveedor" value="@foreach($buy as $row) {{$row->nomC.' '.$row->apeC}} @endforeach" disabled>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class='row col-md-5'>
                                    <b>CI / NIT:</b>
                                    <input type="text" class="form-control form-control-user" name="ci" value="@foreach($buy as $row) {{$row->CI}} @endforeach" disabled>
                                </div>
                            </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-7'>
                                <b>Usuario:</b>
                                <input type="text" class="form-control form-control-user" name="vendedor" required value="@foreach($buy as $row) {{$row->nombres.' '.$row->apellidos}} @endforeach" disabled>
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
                <div class="col-md-6">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4"> <h6><b>COMPRA</b></h6> </div>
                            <div class="col-md-4 text-end" style="color: green">
                                @foreach($buy as $row) 
                                    @if($row->impuesto == 1)
                                        "Esta Compra esta Facturada"
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 card">
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4 mb-3 mb-md-0'>
                                <b>N° Compra:</b>
                                <input type="text" class="form-control form-control-user text-end" id="venNro" name="nro" value="@foreach($buy as $row) {{$row->ID}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4 mb-3 mb-md-0'>
                                <b>Productos:</b>
                                <input type="text" id="venTotalPro" class="form-control form-control-user text-end" name="cantidad" value="@foreach($buy as $row) {{$row->cantidad}} @endforeach" readonly>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>Fecha y Hora:</b>
                                <input type="text" class="form-control form-control-user text-end" name="fecha" value="@foreach($buy as $row) {{formatoFechaHoraVista($row->fecha)}} @endforeach" disabled>
                            </div>
                        </div>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>Impuestos:</b>
                                <input type="text" class="form-control form-control-user text-end" value="@foreach($buy as $row) {{formatoRecibo($row->impuesto)}} @endforeach" disabled>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b>Tipo de pago:</b>
                                <input type="text" class="form-control form-control-user text-end" value="@foreach($buy as $row) {{formatoTransaccion($row->transaccion)}} @endforeach" disabled>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='row col-md-4'>
                                <b style="color:red">Se Pagó (Bs):</b>
                                <br>
                                <input style="color:red; font-weight:bold;" type="text" id="venTotalPag" class="form-control form-control-user text-end" name="total" value="@foreach($buy as $row) {{number_format($row->total,2)}} @endforeach" readonly>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header"> <h6><b>DETALLE</b></h6> </div>
                    <div class="col-md-12 card">
                        <div class="table-responsive table-wrapper">
                            <table class="table table-bordered" id="tablaDetalleCompra" width="100%" cellspacing="0">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection