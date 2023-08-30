@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3>Reporte de Ventas</h3>
        <div class="card shadow mb-4"> <!-- Tarjeta -->
            <div class="card-header py-3"> <!-- Cabecera de la tarjeta -->
                <h5><i class="fas fa-file-pdf"></i> Generar Reporte de Ventas</h5>
            </div>
                <!-- Aqui esta todo el contenido de la pagina -->
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='fas fa-eye'></i></div>
                                <div class="tab-title">&nbsp;Visualizar ventas</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='fas fa-search'></i></div>
                                <div class="tab-title">&nbsp;Busqueda Global</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='fas fa-home'></i></div>
                                <div class="tab-title">&nbsp;Reporte de Ventas</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                        <div class="col-xl-6 mx-auto">
                            <div class="row">
                                <div class="col-md-5 text-end">
                                    <input type="month" class="form-control" id="monthSale" value="{{ date('Y-m') }}">
                                </div>
                                <div class="col-md-7">
                                    <a id="refresh" href="{{ route('report.sales') }}" class="btn btn-warning"> <i class="fas fa-sync"></i> Actualizar</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="tableResponsive">
                            <table class="table table-striped table-bordered" width="100%" id="example2" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Deuda</th>
                                        <th>Total (Bs)</th>
                                        <th>Ver</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum = 0 ?>
                                    @foreach($list as $row)
                                    <tr>
                                        <td>{{ $row->codigo }}</td>
                                        <td>{{ formatoFechaHoraVista($row->fecha) }}</td>
                                        <td>{{ $row->nomC.' '.$row->apeC }}</td>
                                        <td>{{ $row->nombres.' '.$row->apellidos }}</td>
                                        <td>{{ number_format($row->deuda,2) }}</td>
                                        <td class="text-end">{{ number_format($row->total,2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sale.show',$row->ID) }}" type="button" class="btn btn-square-50 btn-info">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                        <?php $sum = $sum + $row->total; ?>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <div class="row ">
                            @csrf
                            <div class="col-md-2 text-center"><h5>N° de Venta:</h5></div>
                            <div class="col-md-2 text-center">
                                <input type="text" class="form-control" id="nroSale" autofocus>
                            </div>
                            <div class="col-md-2 text-center">
                                <button class="btn btn-warning" type="button" id="btnSearch">
                                    <i class="fas fa-search"></i>
                                    <span class="text">Buscar</span>
                                </button>
                            </div>
                            <div class="col-md-2 text-center">
                                <a id="btnGlobalSale" class="btn btn-info" href="#">
                                    <i class="fas fa-eye"></i>
                                    <span class="text">Ver</span>
                                </a>
                            </div>
                            <div class="col-md-2 text-center">
                                <input id="inputCheck" type="text" class="form-control" placeholder="Esperando..." disabled>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                        <form action="{{ route('report.printsales') }}" method="POST" enctype="multipart/form-data" target="_blank">
                            <div class="row">
                                @csrf
                                <div class="col-1 col-lg-1 text-center"><h5>Desde:</h5></div>
                                <div class="col-2 col-lg-2 text-center">
                                    <input class="form-control" id="ini" name="ini" type="date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-1 col-lg-1 text-center"><h5>Hasta:</h5></div>
                                <div class="col-2 col-lg-2 text-center">
                                    <input class="form-control" id="fin" name="fin" type="date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-4 col-lg-4 text-center">
                                    <button class="btn btn-warning" type="submit">
                                        <i class="fas fa-print"></i>
                                        <span class="text">Generar Reporte</span>
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
@endsection
@section('scripts')
    <!-- Plugins para tablas -->
    <script src="{{ asset('template/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/js/table-datatable.js') }}"></script>
    <link href="{{ asset('template/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"/>
    <script>
        $(document).ready(function() {
            changeDate();
        });
        document.getElementById('ini').addEventListener("change", changeDate);
        function changeDate(){
            let ini = document.getElementById('ini');
            let fin = document.getElementById('fin');
            fin.min = ini.value;
            fin.value = ini.value;
        }
        document.getElementById('monthSale').onchange = function(){
            alert(document.getElementById('monthSale').value);
        };
        document.getElementById('btnSearch').onclick = function(){
            let token = $('input[name=_token]').val();
            let nro = document.getElementById('nroSale').value;
            $.ajax({
            url: "{{ route('report.sale') }}",
            type:'post',
            data: {
                _token:token,
                nro:nro,
            },success: function (response) {
                let res = JSON.parse(response);
                if(res.length>0){
                    document.getElementById('inputCheck').removeAttribute('class');
                    document.getElementById('inputCheck').setAttribute('class','form-control is-valid');
                    document.getElementById('inputCheck').value = "Encontrado";
                    document.getElementById('btnGlobalSale').setAttribute('href','{{ asset("sale") }}'+'/'+res[0].ID+'/show');
                }else{
                    document.getElementById('inputCheck').removeAttribute('class');
                    document.getElementById('inputCheck').setAttribute('class','form-control is-invalid');
                    document.getElementById('inputCheck').value = "No existe";
                }
            },statusCode: {
                404: function() { alert('WEB NO ENCONTRADA'); }
            },});
        }
        document.getElementById('monthSale').onchange = function(){
            let token = $('input[name=_token]').val();
            let month = document.getElementById('monthSale').value;
            document.getElementById('refresh').setAttribute('href','{{ asset("report/sales") }}'+'/'+month);
        }
    </script>
@endsection