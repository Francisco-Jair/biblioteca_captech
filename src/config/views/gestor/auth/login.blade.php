@extends('gestor._layouts.login')
@section('header')
    @parent
@stop

@section('content')

    <div class="container bg-glow">
        <div class="login-logo col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2"><img
                    src="{{ url('/') }}/admin/assets/images/logo-horizontal.png" width="200"/></div>
        <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading login-tit">
                    <div class="panel-title">Acesso ao Gênesis</div>
                    <!--div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Esqueceu sua
                            senha?</a></div-->
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    {!! Form::open(['route'=>'gestor.auth.login', 'autocomplete' => 'off', 'id' => 'loginform', 'role' =>
                    'form', 'class' => 'form-horizontal']) !!}

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="email" id="email" value=""
                               placeholder="Seu email cadastrado no Gênesis">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password"
                               placeholder="Sua senha">
                    </div>


                    <!--div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                            </label>
                        </div>
                    </div-->

                    @if(Session::has('mensagem'))
                        <div id="signupalert" class="alert alert-danger">
                            <span>{{Session::get('mensagem')}}</span>
                        </div>
                    @endif

                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-success">Entrar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <!-- JQuery v1.9.1 -->
    <script src="{{ url('/') }}/admin/assets/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>

    <!-- InputMask -->
    <script src="{{ url('/') }}/admin/assets/js/plugins/inputmask/jquery.inputmask.bundle.js"></script>

    <!-- TagsInput -->
    <script src="{{ url('/') }}/admin/assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

    <!-- Custom JQuery -->
    <script src="{{ url('/') }}/admin/assets/js/app/custom.js" type="text/javascript"></script>

    <script src="{{ url('/') }}/admin/assets/js/plugins/jquery.maskedinput.js" type="text/javascript"></script>

@stop

@section('footer')
    @parent
@stop