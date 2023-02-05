<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 16-11-2015
* Time: 02:39:12
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                @if(isset($item->id))
                    <a href="{{{ URL::route('gestor.assuntos.delete', [$item->id]) }}}"
                       id="link-delete"
                       data-toggle="tooltip" data-placement="top"
                       title="Remover"
                       class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                @endif

                @if  (\Request::query('read'))
                    <a href="{{ URL::route('gestor.assuntos.edit', [$item->id]) }}"
                       id="link-enable-edit"
                       data-toggle="tooltip" data-placement="top"
                       title="Editar esse registro"
                       class="btn btn-primary">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                @elseif(isset($item->id))
                    <a href="{{ URL::route('gestor.assuntos.edit', [$item->id]) }}?read=true"
                       id="link-cancel-edit"
                       data-toggle="tooltip" data-placement="top"
                       title="Visualizar esse registro"
                       class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                @endif

                <a href="{{ URL::route('gestor.assuntos.index') }}"
                   id="link-index"
                   data-toggle="tooltip" data-placement="top"
                   title="Listar tudo"
                   class="btn btn-primary">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>

            </div>
            <h3>Assuntos do Contato</h3>
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
                    'route' => ['gestor.assuntos.update', $item->id],
                    'method' => 'put',
                    'id' => 'form-update',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @else
                {!! Form::open(
                [
                    'route' => 'gestor.assuntos.store',
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


            <div class="form-group {{ $errors->has('assunto') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Assunto <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->assunto) ? $item->assunto : null) !!}</p>
                        @else
                        {!! Form::text('assunto', ( isset($item->assunto) ? $item->assunto : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'assunto',
                            'value'=>Input::old('assunto')
                        ]
                        ) !!}
                                <!--script src="{{ url('/') }}/ckeditor/ckeditor.js"></script-->
                        <!--script src="{{ url('/') }}/admin/assets/js/all-ckeditor.js"></script-->

                        {!! $errors->first('assunto','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('emails') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">E-mails <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->emails) ? $item->emails : null) !!}</p>
                    @else
                        {!! Form::text('emails', ( isset($item->emails) ? $item->emails : null),
                        [
                            'placeholder'=>'',
                            'class'=>'form-control',
                            'id' => 'emails',
                            'value'=>Input::old('emails')
                        ]
                        ) !!}
                        <small><em>Separe os emails com virgula</em></small>

                        {!! $errors->first('emails','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
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
    {!! JsValidator::formRequest('App\Http\Requests\AssuntoRequest') !!}
@endsection