@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3>Reporte de Deudores</h3>
        <div class="card shadow mb-4"> <!-- Tarjeta -->
            <div class="card-header py-3"> <!-- Cabecera de la tarjeta -->
                <h5><i class="fas fa-file-pdf"></i> Generar Reporte de Deudores</h5>
            </div>
                <!-- Aqui esta todo el contenido de la pagina -->
            <div class="card-body">
                <div class="tab-content py-3">

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
                                        <th>Deuda (Bs)</th>
                                        <th>Botellas</th>
                                        <th>Total (Bs)</th>
                                        <th>Ver</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum = 0 ?>
                                    @foreach($list as $row)
                                    @if($row->deuda>0 || $row->botellas>0)
                                    <tr>
                                        <td>{{ $row->codigo }}</td>
                                        <td>{{ formatoFechaHoraVista($row->fecha) }}</td>
                                        <td>{{ $row->nomC.' '.$row->apeC }}</td>
                                        <td>{{ $row->nombres.' '.$row->apellidos }}</td>
                                        <td>{{ number_format($row->deuda,2) }}</td>
                                        <td>{{ $row->botellas }}</td>
                                        <td class="text-end">{{ number_format($row->total,2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sale.show',$row->ID) }}" type="button" class="btn btn-square-50 btn-info">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                        <?php $sum = $sum + $row->total; ?>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
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