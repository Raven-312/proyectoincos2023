@extends('general.main')

@section('body')
<!-- Aqui esta todo el contenido de la pagina -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-6">
                <h3>Lista de usuarios</h3>
             
                    <a href="{{ route('user.create') }}" class="btn btn-success btn-addon m-b-sm"><i class="fa fa-plus"></i>Nuevo usuario</a>
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
                                <th>CI</th>
                                <th>Usuario</th>
                                <th>Nombres</th>
                                <th>Acceso</th>
                                <th>Estado</th>
                                <th>Mensaje</th>
                                <th>Modificar</th>
                                <th>Hab/Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $row)
                            <tr>
                                <td>{{ $row->CI }}</td>
                                <td>{{ $row->nomUsu }}</td>
                                <td>{{ $row->nombres.' '.$row->apellidos }}</td>
                                <td>{{ $row->tipo }}</td>
                                <td>{{ formatoEstado($row->estado) }}</td>
                                <td class="text-center">
                                    @if(verificarEstado($row->estado))
                                    <a href="{{ route('message.index',$row->ID) }}" class="btn btn-square-45 btn-info">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('message.index',$row->ID) }}" class="btn btn-square-45 btn-danger">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('user.edit',$row->ID) }}" type="submit" class="btn btn-square-45 btn-secondary">
                                        <i class="fas fa-pen-clip"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form id="formStatus{{$row->ID}}" action="{{ route('user.destroy',$row->ID) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        @if(verificarEstado($row->estado))
                                        <button type="button" class="btn btn-square-40 btn-danger" onclick="auxStatus({{$row->ID}})" data-bs-toggle="modal" data-bs-target="#modalStatus">
                                            <i class="fas fa-x"></i>
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
                <h2><i class="fas fa-circle-question"></i> TextiGenesis</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-body">¿Esta seguro de modificar el estado del usuario?</h4>
                <label>Se cambiara el estado del usuario seleccionada</label>
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