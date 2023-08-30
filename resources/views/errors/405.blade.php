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

<body>
    <div class="error-404 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card py-5">
                <div class="row g-0">
                    <div class="col col-xl-5">
                        <div class="card-body p-4">
                            <h1 class="display-1"><span class="text-success">4</span><span class="text-danger">0</span><span class="text-warning">5</span></h1>
                            <h2 class="font-weight-bold display-4">Ha ocurrido un error</h2>
                                <p>"Respuesta del servidor no soportado"
                                <br>Contactese con el Administrador</p>
                            <div class="mt-6"> <a href="{{ route('menu') }}" class="btn btn-primary btn-lg px-md-5 radius-30">Página Principal</a>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">Atras</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <!--<img src="https://cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.png" class="img-fluid" alt="">-->
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
<!-- Bootstrap JS -->
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('template/js/jquery.min.js') }}"></script>
<script src="{{ asset('template/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('template/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('template/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<!--app JS-->
<script src="{{ asset('template/js/app.js') }}"></script>
</body>

</html>