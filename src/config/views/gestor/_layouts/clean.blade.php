<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SCP - Sistema de Controle de Processos - Infatec</title>

    <meta name="description" content="">
    <meta name="author" content="Infatec - Soluções Tecnológicas">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap/bootstrap.css"/>

    <!-- Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>

    <!-- Base Styling  -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/app/app.v1.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>


@yield('main')


<!-- JQuery v1.9.1 -->
<script src="{{ url('/') }}/assets/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="{{ url('/') }}/assets/js/bootstrap/bootstrap.min.js"></script>

<!-- NanoScroll -->
<script src="{{ url('/') }}/assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>

<!-- Custom JQuery -->
<script src="{{ url('/') }}/assets/js/app/custom.js" type="text/javascript"></script>
</body>
</html>