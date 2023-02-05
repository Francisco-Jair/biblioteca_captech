<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 16-11-2015
* Time: 03:28:52
*/

?>
@extends('gestor._layouts.base')

@section('main')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                {{--<button type="submit"
                        id="button-print"
                        data-toggle="tooltip" data-placement="top"
                        title="Imprimir todos os resultados"
                        class="btn btn-info">
                    <i class="fa fa-print"></i>
                </button>--}}

                {{--<a href="{{ URL::route('gestor.contatos.create') }}"
                   id="link-create"
                   data-toggle="tooltip" data-placement="top"
                   title="Adicionar Novo"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </a>--}}
            </div>
            <h3>Contatos</h3>
        </div>
    </div>

    @include('gestor._layouts.sessionMensagem')

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Listagem</h3>
        </div>

        <div class="panel-body">
            <form name="frm_search_contatos"
                  id="frm_search_contatos"
                  method="get"
                  action="{{ URL::route('gestor.contatos.index') }}"
                  role="form">

                <div class="well">
                    <div class="row">

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="id" class="col-sm-1 control-label">ID </label>

                                {!! Form::text('id', ( \Request::query('id') ? \Request::query('id') : null),
                                    [
                                        'class'=>'form-control',
                                        'id' => 'id',
                                        'placeholder'=>'ID',
                                        'value'=>Input::old('id')
                                    ]
                                ) !!}
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="assunto_id" class="col-sm-2 control-label">Assunto </label>

                                {!! Form::select('assunto_id',
                                    ( isset($options_assunto_id) ? $options_assunto_id : ['0'=>'Implemente $options_assunto_id']),
                                    \Request::query('assunto_id'),
                                    [
                                        'data-placeholder' => 'Selecione um registro',
                                        'class'=>'form-control chosen-select-deselect',
                                        'id' => 'assunto_id'
                                    ]
                                ) !!}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="termo" class="col-sm-2 control-label">Termo </label>

                                {!! Form::text('termo', ( \Request::query('termo') ? \Request::query('termo') : null),
                                    [
                                        'class'=>'form-control',
                                        'id' => 'termo',
                                        'placeholder'=>'',
                                        'value'=>Input::old('termo')
                                    ]
                                ) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="{{ URL::route('gestor.contatos.index') }}"
                               id="link-entrar-pagina"
                               data-toggle="tooltip" data-placement="top"
                               title="Limpar Filtros"
                               class="btn btn-danger"
                               style="margin-right: 5px">
                                <i class="glyphicon glyphicon-home"></i> Limpar Filtros
                            </a>

                            <button type="submit"
                                    id="button-filter"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Filtrar"
                                    class="btn btn-primary pull-right">
                                <i class="fa fa-search"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if ($dados->count())
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, 'id', '#ID') !!}</th>
                        <th>Assunto</th>
                        <th>Nome / E-mail</th>
                        <th>Telefone</th>
                        <th>{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, 'created_at', 'Data de envio') !!}</th>
                        <th width="110" class="text-center">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($dados as $item)
                        <tr @if($item->novo=='N') style="opacity: 0.4;" @endif>
                            <td>{{$item->id}}</td>
                            <td>{{$item->assunto->assunto}}</td>
                            <td>{{$item->nome}}<br/>{{$item->email}}</td>
                            <td>{{$item->telefone}}</td>
                            <td>{{$item->created_at}}</td>
                            <td class="text-center">
                                <a href="{{ URL::route('gestor.contatos.show', [$item->id]) }}?read=true"
                                   id="link-show-{{ $item->id }}"
                                   data-id="{{ $item->id }}"
                                   data-toggle="tooltip" data-placement="top"
                                   title="Visualizar"
                                   class="link-show btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>

                                {{--<a href="{{ URL::route('gestor.contatos.edit', [$item->id]) }}"
                                   id="link-edit-{{ $item->id }}"
                                   data-id="{{ $item->id }}"
                                   data-toggle="tooltip" data-placement="top"
                                   title="Editar"
                                   class="link-edit btn btn-primary">
                                    <i class="fa fa-pencil"></i>
                                </a>--}}

                                <a href="{{ URL::route('gestor.contatos.delete', [$item->id]) }}"
                                   id="link-delete-{{ $item->id }}"
                                   data-id="{{ $item->id }}"
                                   data-toggle="tooltip" data-placement="top"
                                   title="Remover"
                                   class="link-delete btn btn-danger">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {!! $dados->render() !!}
            @else
                @include('gestor._layouts.naoExistemRegistros')
            @endif
        </div>
    </div>
@endsection

@section('scripts')

@endsection