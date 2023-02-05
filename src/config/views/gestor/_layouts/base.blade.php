<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RLustosa {{config('configuracoes.versaoGenesis')}} - {{config('configuracoes.cliente')}}</title>

    <meta name="description" content="">
    <meta name="author" content="Rupert Brasil Lustosa">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="url-filemanager-show" content="{{ url('gestor/filemanager/show') }}"/>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/bootstrap/bootstrap.css"/>

    <!-- Typeahead Styling  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/plugins/typeahead/typeahead.css"/>

    <!-- TagsInput Styling  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css"/>

    <!-- Chosen Select  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/plugins/bootstrap-chosen/chosen.css"/>

    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/plugins/datatables/jquery.dataTables.css"/>

    <!-- DateTime Picker  -->
    <link rel="stylesheet"
          href="{{ url('/') }}/admin/assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css"/>

    <!-- Switch Buttons  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/switch-buttons/switch-buttons.css"/>

    <!-- Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>

    <!-- Base Styling  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/app/app.v1.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CsS Print  -->
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/app/print.css"/>

    <style>
        .obrigatorio {
            font-size: 100%;
            color: red
        }

        header {
            min-height: 0px;
            background: #FFFFFF;
            border-bottom: 1px solid #E5E5E5;
            margin: 0;
            padding: 0;
        }

        header .nav > li > a {
            padding: 3px 16px;
            line-height: 38px;
            cursor: pointer;
            color: #6D6D6D;
            border-left: 1px solid #E1E1E1;
        }

        .navbar-toggle {
            padding: 5px 10px;
        }
    </style>
</head>
<body>

<!-- Preloader -->
<div class="loading-container">
    <div class="loading">
        <div class="l1">
            <div></div>
        </div>
        <div class="l2">
            <div></div>
        </div>
        <div class="l3">
            <div></div>
        </div>
        <div class="l4">
            <div></div>
        </div>
    </div>
</div>
<!-- Preloader -->

<aside class="left-panel {{ isset($valorLeftPanel) ? $valorLeftPanel : null }}">
    <div class="text-center container-fluid">
        <a href="{{{ URL::to('gestor') }}}">
            <img src="{{ url('/') }}/admin/assets/images/logo.png" class="img-responsive"
                 alt="Gênesis">
        </a>
    </div>

    <nav class="navigation">
        <ul class="list-unstyled">
            <li><a href="{{{ URL::to('gestor') }}}"><i class="fa fa-dashboard fa-fw"></i><span
                            class="nav-label">Dashboard</span></a></li>
            @include('gestor._layouts.menu')
        </ul>
    </nav>

</aside>

<section class="content">

    <header class="top-head container-fluid">
        <button type="button" class="navbar-toggle pull-left">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <h4 class="user-name pull-left" style="display:inline; padding-top:5px"><span
                    style="color:#888">Olá </span>
            {{  \Auth::user()->nome  }}
        </h4>

        <ul class="nav nav-pills pull-right">

            <li class="dropdown">
                <!--a href="#" data-toggle="dropdown"> <i
                            class="fa fa-ellipsis-h fa-lg"></i></a>

                <div class="dropdown-menu lg pull-right arrow panel panel-default arrow-top-right">
                    <div class="panel-heading">
                        More Apps
                    </div>
                    <div class="panel-body text-center">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-green"><span class="h2"><i
                                                class="fa fa-envelope-o"></i></span>

                                    <p class="text-gray no-margn">Messages</p></a></div>
                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-purple"><span class="h2"><i
                                                class="fa fa-calendar-o"></i></span>

                                    <p class="text-gray no-margn">Events</p></a></div>

                            <div class="col-xs-12 visible-xs-block">
                                <hr>
                            </div>

                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-red"><span class="h2"><i
                                                class="fa fa-comments-o"></i></span>

                                    <p class="text-gray no-margn">Chatting</p></a></div>

                            <div class="col-lg-12 col-md-12 col-sm-12  hidden-xs">
                                <hr>
                            </div>

                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-yellow"><span class="h2"><i
                                                class="fa fa-folder-open-o"></i></span>

                                    <p class="text-gray">Folders</p></a></div>

                            <div class="col-xs-12 visible-xs-block">
                                <hr>
                            </div>

                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-primary"><span class="h2"><i
                                                class="fa fa-flag-o"></i></span>

                                    <p class="text-gray">Task</p></a></div>
                            <div class="col-xs-6 col-sm-4"><a href="#" class="text-info"><span class="h2"><i
                                                class="fa fa-star-o"></i></span>

                                    <p class="text-gray">Favorites</p></a></div>
                        </div>
                    </div>
                </div-->
            </li>
            <li>
                <a href="{{ URL::route('gestor.gestores.edit', [  Session::get('_id_')]) }}">{{--<span class="hidden-xs hidden-sm hidden-md">Meu Perfil</span>--}}
                    <i class="fa fa-key fa-lg"></i></a></li>
            <li><a href="{{ URL::route('gestor.auth.logout') }}"><span class="hidden-xs hidden-sm hidden-md">Sair</span>
                    <i class="fa fa-sign-out fa-lg"></i></a></li>
        </ul>

        <ul class="nav-toolbar">
        </ul>

    </header>
    <!-- Header Ends -->

    <div class="warper container-fluid">

        @yield('main')

    </div>

    <footer class="container-fluid footer">
        Copyright &copy; 2015 - {{ date('Y') }} <a href="http://rupertlustosa.com.br">RLustosa</a>
        <a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
    </footer>


</section>
<!-- Content Block Ends Here (right box)-->


<!-- JQuery v1.9.1 -->
<script src="{{ url('/') }}/admin/assets/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="{{ url('/') }}/admin/assets/js/bootstrap/bootstrap.min.js"></script>

<!-- NanoScroll -->
<script src="{{ url('/') }}/admin/assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>

<!-- Sparkline JS -->
<script src="{{ url('/') }}/admin/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- For Demo Sparkline -->
<script src="{{ url('/') }}/admin/assets/js/plugins/sparkline/jquery.sparkline.demo.js"></script>


<!-- InputMask -->
<script src="{{ url('/') }}/admin/assets/js/plugins/inputmask/jquery.inputmask.bundle.js"></script>

<!-- TagsInput -->
<script src="{{ url('/') }}/admin/assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<!-- Chosen -->
<script src="{{ url('/') }}/admin/assets/js/plugins/bootstrap-chosen/chosen.jquery.js"></script>

<!-- moment -->
<script src="{{ url('/') }}/admin/assets/js/moment/moment.js"></script>

<!-- DateTime Picker -->
<script src="{{ url('/') }}/admin/assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>

<!-- Custom JQuery -->
<script src="{{ url('/') }}/admin/assets/js/app/custom.js" type="text/javascript"></script>

<script src="{{ url('/') }}/admin/assets/js/plugins/jquery.maskedinput.js" type="text/javascript"></script>

<script src="{{ url('/') }}/admin/assets/js/plugins/jquery.blockUI.js" type="text/javascript"></script>

<script src="{{ url('/') }}/admin/assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
        type="text/javascript"></script>

@yield('scripts')


<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.mascara_telefone').focusout(function () {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if (phone.length > 10) {
            element.mask("(99) 99999-999?9", {placeholder: " "});
        } else {
            element.mask("(99) 9999-9999?9", {placeholder: " "});
        }
    }).trigger('focusout');

    $(".mascara_cpf").mask("999.999.999-99", {placeholder: " "});
    $(".mascara_cep").mask("99999-999", {placeholder: " "});
    $(".mascara_cnpj").mask("99.999.999/9999-99", {placeholder: " "});
    $(".mascara_data").mask("99-99-9999", {
        placeholder: " ", completed: function () {
            console.log("Você digitou a data: " + this.val());
        }
    });

    //,{completed:function(){alert("Você digitou a data: "+this.val());}}
    //$(".mascara_moeda").maskMoney({symbol:"R$", showSymbol:true, decimal:",",thousands:"."/*, symbolStay: true*/, allowZero:true, allowNegative:true, defaultZero:true})

    $('.mascara_numero').keyup(function () {
        var element = $(this);
        var retorno = element.val().replace(/\D/g, '');
        element.val(retorno);
    }).trigger('keyup');

    function block(msg) {
        if (!msg) {
            msg = "Carregando";
        }

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#333',
                '-webkit-border-radius': '6px',
                '-moz-border-radius': '6px',
                'border-radius': '6px',
                opacity: .5,
                color: '#000',
                size: '15px !important'
                /*width: '100%',
                 height: '100%',
                 left: '43%'*/
            },
            overlayCSS: {backgroundColor: '#fff'},
            message: $('<div id="splash" style="display: none;"><img src="{{ url('/') }}/admin/assets/images/loading/ajax-loader.gif" alt="Por favor, aguarde..." /><h1 style="background: none; color: #fff; font-size:16px;">' + msg + '</h1><p>Por favor, aguarde...</p></div>')
        });
    }

    function unblock() {
        $.unblockUI();
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.navbar-toggle').on("click", function () {
            $.ajax({
                        method: "POST",
                        url: "{{ url('/gestor/cookieMenu') }}",
                        data: null,
                        cache: false
                    })
                    .done(function (msg) {
                        console.log('Clique no Menu');
                    })
                    .fail(function () {
                        alert("error");
                    })
                    .always(function () {

                    });
        });
    });

    $('#button-store').on("click", function (e) {
        var btn = $(this);
        //btn.button('loading');
        //btn.attr("disabled", "disabled");
        console.info('Clique em button-store'); //$( this ).text()
        //e.preventDefault();
        /*setTimeout(function () {
         btn.button('reset');
         }, 5000);*/
        //block('Salvando...');
    });
    $("form").submit(function () {
        //jQuery.blockUI();
        //block('Processando...');
    });

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Aviso</h4>
            </div>
            <div class="modal-body" id="myModalInfoMensagem">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>