<!-- Aqui esta la cabecera de la pagina -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        
        <!-- Title -->
        <title>Modern | Admin Dashboard Template</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="{{ asset('template/plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
        <link href="{{ asset('template/plugins/uniform/css/uniform.default.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('template/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('template/plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('template/plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ asset('template/plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ asset('template/plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('template/plugins/3d-bold-navigation/css/style.') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('template/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ asset('template/plugins/weather-icons-master/css/weather-icons.min.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ asset('template/plugins/metrojs/MetroJs.min.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ asset('template/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css"/>	
        	
        <!-- Theme Styles -->
        <link href="{{ asset('css/modern.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
        
        <script src="{{ asset('plugins/3d-bold-navigation/js/modernizr.js') }}"></script>
        
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="page-header-fixed compact-menu page-horizontal-bar">
<!-- 
@yield('sidebar')
@yield('topbar')
@yield('body')
 -->
<!-- Aqui esta todo el contenido de los scripts, fin del body y el footer -->
        <div class="overlay toggle-icon"></div><!-- overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='fas fa-arrow-up'></i></a>
        </div> <!-- Fin Contenedor Interior -->
        <!-- Footer -->
        <footer class="page-footer">
        <div class="container">
		    <p class="no-s">Copyright © {{ date('Y') }} Code Break</p>
            </div>
		</footer>

        
        <!-- Fin Footer -->
    </div>
     <!-- Javascripts -->
        <script src="{{ asset('template/plugins/jquery/jquery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('template/plugins/pace-master/pace.min.js') }}"></script>
        <script src="{{ asset('template/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
        <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('template/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('template/plugins/switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('template/plugins/uniform/jquery.uniform.min.js') }}"></script>
        <script src="{{ asset('template/plugins/classie/classie.js') }}"></script>
        <script src="{{ asset('template/plugins/waves/waves.min.js') }}"></script>
        <script src="{{ asset('template/plugins/3d-bold-navigation/js/main.js') }}"></script>
        <script src="{{ asset('template/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('template/plugins/jquery-counterup/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('template/plugins/flot/jquery.flot.min.js') }}"></script>
        <script src="{{ asset('template/plugins/flot/jquery.flot.time.min.js') }}"></script>
        <script src="{{ asset('template/plugins/flot/jquery.flot.symbol.min.js') }}"></script>
        <script src="{{ asset('template/plugins/flot/jquery.flot.resize.min.js') }}"></script>
        <script src="{{ asset('template/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
        <script src="{{ asset('template/plugins/curvedlines/curvedLines.js') }}"></script>
        <script src="{{ asset('template/plugins/metrojs/MetroJs.min.js') }}"></script>
        <script src="{{ asset('template/js/modern.js') }}"></script>
        <script src="{{ asset('template/js/pages/dashboard.js') }}">
    $(document).ready(function()
    {
        let token = $('input[name=_token]').val();
        let username = document.getElementById('labelUsername').innerHTML;
        //profile
        $.ajax({
        url: "{{ route('session') }}",
        type:'post',
        data: {
            _token:token,
            username:username,
        },success: function (response) {
            let res = JSON.parse(response);
            document.getElementById('labelFullName').innerHTML = res[0].nombres+" "+res[0].apellidos;
            document.getElementById('labelCI').innerHTML = res[0].CI;
            document.getElementById('labelPhone').innerHTML = res[0].contacto;
            document.getElementById('labelEmail').innerHTML = res[0].correo;
            let img = "{{ asset('storage') }}"+"/"+res[0].foto;
            document.getElementById('imgProfile').setAttribute('src',img);
            document.getElementById('imgProfileTopBar').setAttribute('src',img);
        },statusCode: {
            404: function() { alert('WEB NO ENCONTRADA'); }
        },});
        //messages
        $.ajax({
        url: "{{ route('messages') }}",
        type:'post',
        data: {
            _token:token,
        },success: function (response) {
            let res = JSON.parse(response);
            let dropA = document.getElementById('dropdownAlerts');
            let dropM = document.getElementById('dropdownMessages');
            let count = Object.keys(res).length;
            let countMessages = 0;
            let countAlerts = 0;
            for(let i=0;i<count;i++){
                if(res[i].tipo == 0){
                    $(dropM).append(`
                    <a class="dropdown-item" href="message/${res[i].ID}/show">
                        <div class="d-flex align-items-center">
				        	<div class="user-online">
				        		<img src="{{ asset('storage/users/default_user.jpg') }}" class="msg-avatar" alt="user avatar">
				        	</div>
				        	<div class="flex-grow-1">
				        		<h6 class="msg-name">${res[i].asunto}<span class="msg-time float-end">${res[i].fecha}</span></h6>
				        		<p class="msg-info">${res[i].mensaje}</p>
				        	</div>
				        </div>
                    </a>
                    `);
                    countMessages++;
                }else{
                    $(dropA).append(`
                    <a class="dropdown-item" href="message/${res[i].ID}/show">
				    	<div class="d-flex align-items-center">
				    		<div class="notify bg-light-primary text-primary"><i class="fas fa-exclamation"></i>
				    		</div>
				    		<div class="flex-grow-1">
				    			<h6 class="msg-name">Mensaje Importante<span class="msg-time float-end">${res[i].fecha}</span></h6>
				    			<p class="msg-info">${res[i].asunto}</p>
				    		</div>
				    	</div>
				    </a>
                    `);
                    countAlerts++;
                }
            }
            if(countMessages>0){
                document.getElementById('countMessages').setAttribute('class','alert-count');
                document.getElementById('countMessages').innerHTML = countMessages;
            }
            if(countAlerts){
                document.getElementById('countAlerts').setAttribute('class','alert-count');
                document.getElementById('countAlerts').innerHTML = countAlerts;
            }
        },statusCode: {
            404: function() { alert('WEB NO ENCONTRADA'); }
        },});
    });
</script>
    @yield('scripts')
</body>
</html>