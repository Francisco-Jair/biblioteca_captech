<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 16-11-2015
* Time: 02:48:47
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                @if(isset($item->id))
                    <a href="{{{ URL::route('gestor.gestores.delete', [$item->id]) }}}"
                       id="link-delete"
                       data-toggle="tooltip" data-placement="top"
                       title="Remover"
                       class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                @endif

                @if  (\Request::query('read'))
                    <a href="{{ URL::route('gestor.gestores.edit', [$item->id]) }}"
                       id="link-enable-edit"
                       data-toggle="tooltip" data-placement="top"
                       title="Editar esse registro"
                       class="btn btn-primary">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                @elseif(isset($item->id))
                    <a href="{{ URL::route('gestor.gestores.edit', [$item->id]) }}?read=true"
                       id="link-cancel-edit"
                       data-toggle="tooltip" data-placement="top"
                       title="Visualizar esse registro"
                       class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                @endif

                <a href="{{ URL::route('gestor.gestores.index') }}"
                   id="link-index"
                   data-toggle="tooltip" data-placement="top"
                   title="Listar tudo"
                   class="btn btn-primary">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>

            </div>
            <h3>Gestores</h3>
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
                    'route' => ['gestor.gestores.update', $item->id],
                    'method' => 'put',
                    'id' => 'form-update',
                    'class' => 'form-horizontal form-save',
                    'autocomplete' => 'off',
                    'role' => 'form'
                ]) !!}
            @else
                {!! Form::open(
                [
                    'route' => 'gestor.gestores.store',
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
                                <!--script src="{{ url('/') }}/ckeditor/ckeditor.js"></script-->
                        <!--script src="{{ url('/') }}/admin/assets/js/all-ckeditor.js"></script-->

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
                                <!--script src="{{ url('/') }}/ckeditor/ckeditor.js"></script-->
                        <!--script src="{{ url('/') }}/admin/assets/js/all-ckeditor.js"></script-->

                        {!! $errors->first('email','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>


            <div class="form-group {{ $errors->has('password') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Password <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->password) ? $item->password : null) !!}</p>
                    @else
                        {!! Form::password('password', null,
                        [
                            'placeholder'=>'Digite uma senha de pelo menos 6 dígitos',
                            'class'=>'form-control',
                            'id' => 'password'
                        ]
                        ) !!}

                        {!! $errors->first('password','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="help-block"><small>:message</small></span>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error has-feedback' : '' }}">
                <label class="col-sm-2 control-label">Confirme <span class="obrigatorio">*</span></label>

                <div class="col-sm-7">
                    @if  (\Request::query('read'))
                        <p class="form-control-static">{!! ( isset($item->password_confirmation) ? $item->password_confirmation : null) !!}</p>
                    @else
                        {!! Form::password('password_confirmation', null,
                        [
                            'placeholder'=>'Repita a senha',
                            'class'=>'form-control',
                            'id' => 'password_confirmation'
                        ]
                        ) !!}

                        {!! $errors->first('password_confirmation','<span class="glyphicon glyphicon-remove form-control-feedback"></span>
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
    {!! JsValidator::formRequest('App\Http\Requests\GestorRequest') !!}
@endsection