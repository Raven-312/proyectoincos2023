@extends('general.main')

@section('body')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-9 col-lg-9">
                <h1 class="h3 mb-2 text-gray-800">Estadísticas</h1>
            </div>    
            <div class="col-3 col-lg-3 text-end">
            <label for="menuYear">Gestión: </label>
                <select name="year" id="menuYear">
                    @foreach($years as $row)
                        @if($row->Year == date('Y'))
                        <option value="{{ $row->Year }}" selected>{{ $row->Year }}</option>
                        @else
                        <option value="{{ $row->Year }}">{{ $row->Year }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xl-8 col-lg-8">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gráfico de Área</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container1" id="chartArea">
                        </div>
                        <hr>
                        <h6>Resumen de ventas del año <b id="yearSale">{{ date('Y') }}</b> distribuido por meses</h6>
                    </div>
                </div>
            </div>
            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gráfico Circular</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-container1" id="chartPie"></div>
                        <hr>
                        <h6>Productos mas vendidos en el año <b id="maxYearProduct">{{ date('Y') }}</b></h6>
                        <h6>Producto mas vendido: <b id="maxProduct"></b></h6>
                    </div>
                </div>
            </div>
            <select class="form-control" id="menuGain" hidden>
                @foreach($earlings as $row)
                <option value="{{ $row->Total }}">{{ $row->Gestion. '-'.$row->Mes }}</option>
                @endforeach
            </select>
            <select class="form-control" id="menuProducts" hidden>
                @foreach($materiales as $row)
                <option value="{{ $row->Cantidad }}">{{ $row->Gestion.' '.$row->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Javascript para graficas -->
    <script src="{{ asset('template/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/chartjs/js/chartjs-custom.js') }}"></script>
@endsection