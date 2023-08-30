@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <h3>Centro de Mensajeria y Alertas</h3>
        <hr>
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="card border-top border-0 border-4 border-dark"> <!-- Tarjeta -->
                    <div class="card-body py-0 px-0"> <!-- Cuerpo de la tarjeta -->
                        <div class="email-wrapper">
                            <div class="email-sidebar">
                                <div class="email-sidebar-header d-grid"> <a href="{{ route('user.index') }}" class="btn btn-primary compose-mail-btn"><i class='fas fa-plus me-2'></i>Redactar Mensaje</a></div>
                                <div class="email-sidebar-content">
                                    <div class="email-navigation">
                                        <div class="list-group list-group-flush">
                                            <a href="#" class="list-group-item active d-flex align-items-center"><i class='fas fa-inbox me-3 font-20'></i>
                                                <span>Mensajes</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email-header d-xl-flex align-items-center">
                                <div class="ms-auto d-flex align-items-center">
                                    <label class="btn btn-sm btn-light">Total Mensajes: {{ $con }}</label>
                                </div>
                            </div>
                            <div class="email-content">
                                <div>
                                    <div class="email-list">
                                        @foreach($messages as $row)
                                        <a href="{{ route('message.show',$row->ID) }}">
                                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                                <div class="d-flex align-items-center email-actions">
                                                    @if(verificarEstado($row->estado))
                                                    <input type="checkbox" disabled checked/>
                                                        @if($row->tipo == 0)
                                                        <i class="fas fa-envelope font-20 mx-2"></i>
                                                        @else
                                                        <i class="fas fa-bell font-20 mx-2"></i>
                                                        @endif
                                                    @else
                                                    <input type="checkbox" disabled/>
                                                        @if($row->tipo == 0)
                                                        <i class="fas fa-envelope font-20 mx-2"></i>
                                                        @else
                                                        <i class="fas fa-bell font-20 mx-2"></i>
                                                        @endif
                                                    @endif
                                                    <p class="mb-0"><b>{{ $row->nombres.' '.$row->apellidos }}</b></p>
                                                </div>
                                                <div>
                                                    <p class="mb-0">{{ $row->mensaje }}</p>
                                                </div>
                                                <div class="ms-auto">
                                                    <p class="mb-0 email-time">{{ formatoFechaHoraVista($row->fecha) }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('template/js/app-emailbox.js')}}"></script>
@endsection