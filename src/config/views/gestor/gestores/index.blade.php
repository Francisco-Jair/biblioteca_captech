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
                {{--<button type="submit"
                        id="button-print"
                        data-toggle="tooltip" data-placement="top"
                        title="Imprimir todos os resultados"
                        class="btn btn-info">
                    <i class="fa fa-print"></i>
                </button>--}}

                <a href="{{ URL::route('gestor.gestores.create') }}"
                   id="link-create"
                   data-toggle="tooltip" data-placement="top"
                   title="Adicionar Novo"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <h3>Gestores</h3>
        </div>
    </div>

    @include('gestor._layouts.sessionMensagem')

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Listagem</h3>
        </div>

        <div class="panel-body">

            <div class="well" style="display: none">
                <div class="row">

                    {{--<div class="form-group">
                        <label for="id" class="col-sm-2 control-label">#ID </label>

                        {!! Form::text('id', ( \Request::query('id') ? \Request::query('id') : null),
                            [
                                'class'=>'form-control',
                                'id' => 'id',
                                'placeholder'=>'',
                                'value'=>Input::old('id')
                            ]
                        ) !!}
                    </div>--}}

                    {{--<div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome </label>

                        {!! Form::text('nome', ( \Request::query('nome') ? \Request::query('nome') : null),
                            [
                                'class'=>'form-control',
                                'id' => 'nome',
                                'placeholder'=>'',
                                'value'=>Input::old('nome')
                            ]
                        ) !!}
                    </div>--}}

                    {{--<div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail </label>

                        {!! Form::text('email', ( \Request::query('email') ? \Request::query('email') : null),
                            [
                                'class'=>'form-control',
                                'id' => 'email',
                                'placeholder'=>'',
                                'value'=>Input::old('email')
                            ]
                        ) !!}
                    </div>--}}

                    {{--<div class="form-group">
                        <label for="created_at" class="col-sm-2 control-label">Data de criação </label>

                        {!! Form::text('created_at', ( \Request::query('created_at') ? \Request::query('created_at') : null),
                            [
                                'class'=>'form-control',
                                'id' => 'created_at',
                                'placeholder'=>'',
                                'value'=>Input::old('created_at')
                            ]
                        ) !!}
                    </div>--}}

                    {{--<div class="form-group">
                        <label for="updated_at" class="col-sm-2 control-label">Data de atualização </label>

                        {!! Form::text('updated_at', ( \Request::query('updated_at') ? \Request::query('updated_at') : null),
                            [
                                'class'=>'form-control',
                                'id' => 'updated_at',
                                'placeholder'=>'',
                                'value'=>Input::old('updated_at')
                            ]
                        ) !!}
                    </div>--}}


                    <div class="col-sm-4">
                        <div class="form-group">

                        </div>
                        <div class="form-group">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">

                        </div>
                        <div class="form-group">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">

                        </div>
                        <div class="form-group">

                        </div>

                        <button type="button"
                                id="button-filter"
                                data-toggle="tooltip" data-placement="top"
                                title="Filtrar"
                                class="btn btn-primary pull-right">
                            <i class="fa fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </div>


            @if ($dados->count())
                <form name="frm_search_gestores"
                      id="frm_search_gestores"
                      method="get"
                      action="{{ URL::route('gestor.gestores.index') }}"
                      class="form-horizontal"
                      role="form">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, 'created_at', 'Data de criação') !!}</th>
                            <th>{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, 'updated_at', 'Data de atualização') !!}</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td>{{$item->nome}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td class="text-right">
                                    <a href="{{ URL::route('gestor.gestores.show', [$item->uid]) }}?read=true"
                                       id="link-show-{{ $item->uid }}"
                                       data-id="{{ $item->uid }}"
                                       data-toggle="tooltip" data-placement="top"
                                       title="Visualizar"
                                       class="link-show btn btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ URL::route('gestor.gestores.edit', [$item->uid]) }}"
                                       id="link-edit-{{ $item->uid }}"
                                       data-id="{{ $item->uid }}"
                                       data-toggle="tooltip" data-placement="top"
                                       title="Editar"
                                       class="link-edit btn btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <a href="{{ URL::route('gestor.gestores.delete', [$item->uid]) }}"
                                       id="link-delete-{{ $item->uid }}"
                                       data-id="{{ $item->uid }}"
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
                </form>
                {!! $dados->render() !!}
            @else
                @include('gestor._layouts.naoExistemRegistros')
            @endif
        </div>
    </div>
@endsection

@section('scripts')

@endsection