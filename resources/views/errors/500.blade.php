<!-- Aqui esta la cabecera de la pagina -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Genesis-Lite</title>

    <!-- Css para la pagina figuras y fuente-->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- logo -->
    <link rel="icon" href="{{ asset('template/images/favicon-32x32.png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('template/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('template/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('template/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('template/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('template/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('template/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="{{ asset('template/css/app.css') }}" rel="stylesheet">
	
</head>

<body>
    <div class="error-404 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-xl-5">
                        <div class="card-body p-4">
                            <h1 class="display-1"><span class="text-warning">5</span><span class="text-danger">0</span><span class="text-primary">0</span></h1>
                            <h2 class="font-weight-bold display-4">Error inesperado</h2>
                            <p>Error de Servidor!!!
                            <br> - Revise su conección a internet
                            <br> - Contactese con el Administrador</p>
                            <div class="mt-5">	<a href="{{ route('menu') }}" class="btn btn-lg btn-primary px-md-5 radius-30">Salir</a>
                                <a href="{{ url()->previous() }}" class="btn btn-lg btn-outline-dark ms-3 px-md-5 radius-30">Atras</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <img src="{{asset('template/images/errors-images/505-error.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>