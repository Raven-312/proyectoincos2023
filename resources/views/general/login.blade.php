<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title>Textiles "Nueva York" | Iniciar Sesión </title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="{{asset('template/plugins/pace-master/themes/blue/pace-theme-flash.css')}}" rel="stylesheet"/>
        <link href="{{asset('template/plugins/uniform/css/uniform.default.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('template/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/>	
        <link href="{{asset('template/plugins/waves/waves.min.css')}}" rel="stylesheet" type="text/css"/>	
        <link href="{{asset('template/plugins/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/plugins/3d-bold-navigation/css/style.')}}" rel="stylesheet" type="text/css"/>	
        
        <!-- Theme Styles -->
        <link href="{{asset('template/css/modern.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/css/custom.css')}}" rel="stylesheet" type="text/css"/>
        
        <script src="{{asset('template/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>
        
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="index.html" class="logo-name text-lg text-center">Textiles "Nueva York"</a>
                                <p class="text-center m-t-md">Porfavor, ingresa tus datos</p>
                                <form class="m-t-md" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="col-12">
												<label for="inputEmailAddress" class="form-label">Usuario:</label>
												<input type="text" class="form-control" id="inputEmailAddress" name="username" placeholder="Nombre de usuario">
												@error('username')
												<div class="alert alert-danger border-0 py-0 bg-danger">
													<div class="text-white">{{ $message }}</div>
												</div>
                                        		@enderror
											</div>
											<br>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Contraseña:</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Ingrese su contraseña"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="fa fa-eye-slash"></i> </a>
												</div>
												@error('password')
												<div class="alert alert-danger border-0 py-0 bg-danger">
													<div class="text-white">{{ $message }}</div>
												</div>
                                        		@enderror
											</div>
                                    <button type="submit" class="btn btn-success btn-block">Iniciar</button>
                                    <a href="{{ route('email') }}" class="display-block text-center m-t-md text-sm">¿Olvidaste tu contraseña?</a>
                                    <p class="text-center m-t-xs text-sm">¿No tienes una cuenta?</p>
                                    <a href="register.html" class="btn btn-default btn-block m-t-md">Create an account</a>
                                </form>
                                <p class="text-center m-t-xs text-sm">2023 &copy; Code Break BO</p>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	

        <!-- Javascripts -->
        <script src="{{asset('template/plugins/jquery/jquery-2.1.4.min.js')}}"></script>
        <script src="{{asset('template/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('template/plugins/pace-master/pace.min.js')}}"></script>
        <script src="{{asset('template/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
        <script src="{{asset('template/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('template/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{asset('template/plugins/switchery/switchery.min.js')}}"></script>
        <script src="{{asset('template/plugins/uniform/jquery.uniform.min.js')}}"></script>
        <script src="{{asset('template/plugins/classie/classie.js')}}"></script>
        <script src="{{asset('template/plugins/waves/waves.min.js')}}"></script>
        <script src="{{asset('template/js/modern.min.js')}}"></script>

        <!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').removeClass("fas fa-eye");
					$('#show_hide_password i').addClass("fas fa-eye-slash");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("fas fa-eye-slash");
					$('#show_hide_password i').addClass("fas fa-eye");
				}
			});
		});
	</script>
	<!--app JS-->
        
    </body>
</html>