<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 17-11-2015
* Time: 03:07:00
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                @if(isset($item->id))
                    <a href="{{{ URL::route('gestor.log_atividades.delete', [$item->id]) }}}"
                       id="link-delete"
                       data-toggle="tooltip" data-placement="top"
                       title="Remover"
                       class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                @endif

                {{--@if  (\Request::query('read'))
                    <a href="{{ URL::route('gestor.log_atividades.edit', [$item->id]) }}"
                        id="link-enable-edit"
                        data-toggle="tooltip" data-placement="top"
                        title="Editar esse registro"
                        class="btn btn-primary">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                @elseif(isset($item->id))
                    <a href="{{ URL::route('gestor.log_atividades.edit', [$item->id]) }}?read=true"
                        id="link-cancel-edit"
                        data-toggle="tooltip" data-placement="top"
                        title="Visualizar esse registro"
                        class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                @endif--}}

                <a href="{{ URL::route('gestor.log_atividades.index') }}"
                   id="link-index"
                   data-toggle="tooltip" data-placement="top"
                   title="Listar tudo"
                   class="btn btn-primary">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>

            </div>
            <h3>Log de Atividades</h3>
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
                    'route' => ['gestor.log_atividades.update', $item->id],
                    'method' => 'put',
                    'id' => 'form-update',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @else
                {!! Form::open(
                [
                    'route' => 'gestor.log_atividades.store',
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


            <div class="form-group {{ $errors->has('gestor_id') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Gestor <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->gestor_id) ? $item->gestor->nome : null) !!}</p>
                    @else
                        {!! Form::select('gestor_id',
                            ( isset($options_gestor_id) ? $options_gestor_id : ['0'=>'Implemente $options_gestor_id']),
                            ( isset($item->gestor_id) ? $item->gestor_id : null),
                            [
                                'data-placeholder' => 'Selecione um registro',
                                'class'=>'form-control chosen-select-deselect',
                                'id' => 'gestor_id',
                                'value'=>Input::old('gestor_id')
                            ]
                        ) !!}

                        {!! $errors->first('gestor_id','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('operacao') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Operação <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->operacao) ? $item->operacao : null) !!}</p>
                    @else
                        {!! Form::text('operacao', ( isset($item->operacao) ? $item->operacao : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'operacao',
                            'value'=>Input::old('operacao')
                        ]
                        ) !!}

                        {!! $errors->first('operacao','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('modulo') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Módulo <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->modulo) ? $item->modulo : null) !!}</p>
                    @else
                        {!! Form::text('modulo', ( isset($item->modulo) ? $item->modulo : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'modulo',
                            'value'=>Input::old('modulo')
                        ]
                        ) !!}

                        {!! $errors->first('modulo','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('pagina') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Página <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->pagina) ? $item->pagina : null) !!}</p>
                    @else
                        {!! Form::textarea('pagina', ( isset($item->pagina) ? $item->pagina : null),
                        [
                            'class'=>'form-control',
                            'id' => 'pagina',
                            'size' => '30x5',
                            #'maxlength' => '255',
                            'value'=>Input::old('pagina')
                        ]
                        ) !!}

                        {!! $errors->first('pagina','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('dados') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Dados <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->dados) ? $item->dados : null) !!}</p>
                    @else
                        {!! Form::textarea('dados', ( isset($item->dados) ? $item->dados : null),
                        [
                            'class'=>'form-control',
                            'id' => 'dados',
                            'size' => '30x5',
                            #'maxlength' => '255',
                            'value'=>Input::old('dados')
                        ]
                        ) !!}

                        {!! $errors->first('dados','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
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
    {!! JsValidator::formRequest('App\Http\Requests\LogAtividadeRequest') !!}

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