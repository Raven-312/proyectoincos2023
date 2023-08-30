@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3>Mensaje</h3>
        <hr>
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-header py-3 text-end"> <!-- Cabecera de la tarjeta -->
                        <h5><b>Fecha: </b>@foreach($message as $row) {{ formatoFechaHoraVista($row->fecha) }} @endforeach</h5>
                    </div>
                    <div class="card-body py-3 px-5"> <!-- Cuerpo de la tarjeta -->
                        <form action="{{ route('message.store') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                @csrf
                                <h5><i class="fas fa-envelope"></i> Mensaje:</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>De:</b> @foreach($message as $row) {{ $row->nombres.' '.$row->apellidos }} @endforeach </h6>
                                    </div>
                                    <div class="col-md-12">
                                        <h6><b>Para:</b> Mi</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <h6><b>Asunto:</b> @foreach($message as $row){{ $row->asunto }}@endforeach</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <h6><b>Mensaje: </b>@foreach($message as $row){{ $row->mensaje }}@endforeach</h6>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <a class="btn btn-warning" href="{{ route('message.center') }}">
                                        <i class="fas fa-envelope"></i>Centro de Mensajeria
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection