<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alto Centro | @yield('title','Corporación Alto Centro')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    <link rel="icon" href="{{url('/')}}/images/favicon.ico" type="image/x-icon">
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="{{url('/')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Jquery UI CSS -->
    <link href="{{url('/')}}/css/jquery-ui.min.css" rel="stylesheet">
    <link href="{{url('/')}}/css/jquery-ui.theme.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{url('/')}}/css/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS --> 
    <link href="{{url('/')}}/css/sb-admin-2.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    
    <!-- blueimp Gallery styles -->
    <!--<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">-->
    <link href="{{url('/')}}/css/blueimp-gallery.min.css" rel="stylesheet">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{url('/')}}/css/jquery.fileupload.css">
    <link rel="stylesheet" href="{{url('/')}}/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{url('/')}}/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="{{url('/')}}/css/jquery.fileupload-ui-noscript.css"></noscript>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="app-layout">
    <div id="wrapper">
    <!-- START OF HEADER -->
        <!-- Navigation -->
        <div id="head"></div>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header visible-xs">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Alto Centro</a>
            </div>
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav hidden-xs" id="logo"><a href="#header">
                <img src="{{ url('/images') }}/altocentro.png" alt="" height="70" width="240"></a>
            </ul>
            <!-- /.navbar-header -->
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Inicio</a></li>
                @else
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            {{ Auth::user()->name }} <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i>Perfil del Usuario</a>
                            </li>
                            <li><a href="{{ url('password/reset') }}"><i class="fa fa-gear fa-fw"></i>Cambiar Clave</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                @endif
                <!-- /.dropdown -->
                <li class="dropdown hidden-xs"><?php $mytime = Carbon\Carbon::now('America/Caracas'); echo $mytime->toDayDateTimeString(); ?></li>
            </ul>
            <!-- /.navbar-top-links -->
            @if (Auth::check())
                @include('layouts.menu')
            @endif
        </nav>
        <!-- END OF HEADER -->
        
        <!-- START OF MAIN CONTENT -->
        @if(Auth::guest())
            <div id="page-wrapper" class="page-wrapper no-menu">
        @else
            <div id="page-wrapper" class="page-wrapper<?PHP if($_SERVER['REQUEST_URI'] == '/altocentro/public/'){ echo ' home'; } ?>">
        @endif
       
            <div class="row">
                <h3>
                    @yield('title')
                </h3>
            </div>
            <!-- /.row -->
            @if (Session::has('message'))
                <div id="result" class="alert alert-danger">
                    {{Session::get('message')}}  
                </div>
            @else
                <div id="result"></div>
            @endif
            @if (Session::has('status'))
                <div class="alert alert-success">
                    {{Session::get('status')}}
                </div>
            @endif
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <!-- /.row -->
            <div class="row">
                @yield('content')
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        <!-- foot -->
        <div id="footer">
            &copy; {{ date('Y') }} GRUPO ALTOCENTRO, S.C. - Todos los derechos reservados | RIF: J-30991480-4 |  Desarrollado por <a href="http://brizerconsulting.com/" target="_blank">BrizerConsulting.com</a>
        </div>
    </div>
    <!-- /#wrapper -->
    <!-- JavaScripts -->
    <script src="{{url('/')}}/bootstrap/js/jquery-1.12.3.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
    <!-- BOOTSTRAP -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <script src="{{url('/')}}/bootstrap/js/bootstrap.min.js"></script>
    <!--Jquery-ui-->
    <script src="{{url('/')}}/js/jquery-ui.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{url('/')}}/js/metisMenu.min.js"></script>
    <script src="{{url('/')}}/js/sb-admin-2.js"></script>
    <script src="{{url('/')}}/js/parsley.min.js"></script>
    <script src="{{url('/')}}/js/i18n/es.js"></script>
    <script src="{{url('/')}}/js/typeahead.bundle.js"></script>
    
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('script')
</body>
</html>
