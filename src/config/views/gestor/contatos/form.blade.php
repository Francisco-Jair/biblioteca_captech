<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 16-11-2015
* Time: 03:28:53
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                @if(isset($item->id))
                    <a href="{{{ URL::route('gestor.contatos.delete', [$item->id]) }}}"
                       id="link-delete"
                       data-toggle="tooltip" data-placement="top"
                       title="Remover"
                       class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                @endif

                <a href="{{ URL::route('gestor.contatos.index') }}"
                   id="link-index"
                   data-toggle="tooltip" data-placement="top"
                   title="Listar tudo"
                   class="btn btn-primary">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>

            </div>
            <h3>Contatos</h3>
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
                    'route' => ['gestor.contatos.update', $item->id],
                    'method' => 'put',
                    'id' => 'form-update',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @else
                {!! Form::open(
                [
                    'route' => 'gestor.contatos.store',
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


            <div class="form-group {{ $errors->has('assunto_id') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Assunto <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->assunto_id) ? $item->assunto_id : null) !!}</p>
                    @else
                        {!! Form::select('assunto_id',
                            ( isset($options_assunto_id) ? $options_assunto_id : ['0'=>'Implemente $options_assunto_id']),
                            ( isset($item->assunto_id) ? $item->assunto_id : null),
                            [
                                'data-placeholder' => 'Selecione um registro',
                                'class'=>'form-control chosen-select-deselect',
                                'id' => 'assunto_id',
                                'value'=>Input::old('assunto_id')
                            ]
                        ) !!}

                        {!! $errors->first('assunto_id','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('nome') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Nome <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->nome) ? $item->nome : null) !!}</p>
                    @else
                        {!! Form::text('nome', ( isset($item->nome) ? $item->nome : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'nome',
                            'value'=>Input::old('nome')
                        ]
                        ) !!}

                        {!! $errors->first('nome','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">E-mail <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->email) ? $item->email : null) !!}</p>
                    @else
                        {!! Form::text('email', ( isset($item->email) ? $item->email : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'email',
                            'value'=>Input::old('email')
                        ]
                        ) !!}

                        {!! $errors->first('email','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('telefone') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Telefone <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->telefone) ? $item->telefone : null) !!}</p>
                    @else
                        {!! Form::text('telefone', ( isset($item->telefone) ? $item->telefone : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'telefone',
                            'value'=>Input::old('telefone')
                        ]
                        ) !!}

                        {!! $errors->first('telefone','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('mensagem') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Mensagem <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->mensagem) ? $item->mensagem : null) !!}</p>
                    @else
                        {!! Form::textarea('mensagem', ( isset($item->mensagem) ? $item->mensagem : null),
                        [
                            'class'=>'form-control',
                            'id' => 'mensagem',
                            'size' => '30x5',
                            'value'=>Input::old('mensagem')
                        ]
                        ) !!}

                        {!! $errors->first('mensagem','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('mensagem') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Robô? <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static"></p>
                    @else
                        {!! Recaptcha::render() !!}

                        {!! $errors->first('g-recaptcha-response','<span
                    class="glyphicon glyphicon-remove form-control-feedback"></span><span
                    class="help-block alerta"><small>:message</small></span>') !!}
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
    {!! JsValidator::formRequest('App\Http\Requests\ContatoRequest') !!}
@endsection