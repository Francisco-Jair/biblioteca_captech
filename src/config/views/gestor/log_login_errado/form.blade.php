<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 17-11-2015
* Time: 03:00:07
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                @if(isset($item->id))
                    <a href="{{{ URL::route('gestor.log_login_errado.delete', [$item->id]) }}}"
                       id="link-delete"
                       data-toggle="tooltip" data-placement="top"
                       title="Remover"
                       class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                @endif

                {{--@if  (\Request::query('read'))
                    <a href="{{ URL::route('gestor.log_login_errado.edit', [$item->id]) }}"
                        id="link-enable-edit"
                        data-toggle="tooltip" data-placement="top"
                        title="Editar esse registro"
                        class="btn btn-primary">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                @elseif(isset($item->id))
                    <a href="{{ URL::route('gestor.log_login_errado.edit', [$item->id]) }}?read=true"
                        id="link-cancel-edit"
                        data-toggle="tooltip" data-placement="top"
                        title="Visualizar esse registro"
                        class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                @endif--}}

                <a href="{{ URL::route('gestor.log_login_errado.index') }}"
                   id="link-index"
                   data-toggle="tooltip" data-placement="top"
                   title="Listar tudo"
                   class="btn btn-primary">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>

            </div>
            <h3>Log de Falhas de Login</h3>
        </div>
    </div>

    @include('gestor._layouts.sessionMensagem')

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-list"></i> {{ \Request::query('read') ? 'Visualização' : (isset($item->id) ? 'Edição' : 'Cadastro') }}
            </h3>
        </div>

        <div class="panel-body">
            @if (isset($item->id))
                {!! Form::open(
                [
                    'route' => ['gestor.log_login_errado.update', $item->id],
                    'method' => 'put',
                    'id' => 'form-update',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @else
                {!! Form::open(
                [
                    'route' => 'gestor.log_login_errado.store',
                    'id' => 'form-store',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @endif

            @if($errors->any())

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            @if($errors->count() == 1)
                                Verifique o erro abaixo:
                            @else
                                Verifique os {{ $errors->count() }} erros abaixo:
                            @endif
                        </div>
                    </div>
                </div>

                {{--<ul class="alert">
                    <li>Verifique os erros abaixo!</li>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>--}}
            @endif


            <div class="form-group {{ $errors->has('ip') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">IP <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->ip) ? $item->ip : null) !!}</p>
                    @else
                        {!! Form::text('ip', ( isset($item->ip) ? $item->ip : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'ip',
                            'value'=>Input::old('ip')
                        ]
                        ) !!}

                        {!! $errors->first('ip','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('login') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Login <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->login) ? $item->login : null) !!}</p>
                    @else
                        {!! Form::text('login', ( isset($item->login) ? $item->login : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'login',
                            'value'=>Input::old('login')
                        ]
                        ) !!}

                        {!! $errors->first('login','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('senha') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Senha <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->senha) ? $item->senha : null) !!}</p>
                    @else
                        {!! Form::text('senha', ( isset($item->senha) ? $item->senha : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'senha',
                            'value'=>Input::old('senha')
                        ]
                        ) !!}

                        {!! $errors->first('senha','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="text-right">
                @if  (!\Request::query('read'))
                    <button type="submit"
                            id="button-store"
                            class="btn btn-info"
                            data-loading-text="Aguarde...">
                        <span class="glyphicon glyphicon-floppy-disk"></span> {{ (isset($item->id) ? 'Salvar' : 'Adicionar') }}
                    </button>
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    @endsection

    @section('scripts')
            <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LogLoginErradoRequest') !!}

    <script type="text/javascript">
        $(document).ready(function () {
            {{--
            $(\'textarea#IdDeAlgumCampo\').maxlength({
                alwaysShow: true,
                threshold: 30,
                warningClass: "label label-info",
                limitReachedClass: "label label-warning",
                placement: \'bottom\',
                message: \'Utilizado %charsTyped% de %charsTotal% caracteres.\'
            });
            // Não esquecer de acrescentar no campo: 'maxlength' => '999',
            --}}
            console.info('Jquery Ready');
        });
    </script>
@endsection