<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gênesis - {{config('configuracoes.cliente')}}</title>

    <meta name="description" content="">
    <meta name="author" content="Rupert Brasil Lustosa">

    @section('header')
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/bootstrap/bootstrap.css') }}" />

    <!-- Fonts  -->
    <link href='{{ asset('/admin/assets/fonts/css-font-raleway.css') }}' rel='stylesheet' type='text/css'>

    <!-- Base Styling  -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/app/app.v1.css') }}" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @show

</head>
<body class="login-body">


<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>


@section('footer')
        <!-- JQuery v1.9.1 -->
<script src="{{ asset('/admin/assets/js/jquery/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/admin/assets/js/plugins/underscore/underscore-min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/admin/assets/js/bootstrap/bootstrap.min.js') }}"></script>

<!-- Globalize -->
<script src="{{ asset('/admin/assets/js/globalize/globalize.min.js') }}"></script>

<!-- NanoScroll -->
<script src="{{ asset('/admin/assets/js/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>

<!-- Custom JQuery -->
<script src="{{ asset('/admin/assets/js/app/custom.js') }}" type="text/javascript"></script>
@stop
</body>

</html>