<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
* Date: 17-11-2015
* Time: 04:53:06
*/

?>

@extends('gestor._layouts.base')

@section('main')
        <!-- Image Cropper  -->
<link rel="stylesheet" href="{{ url('/') }}/admin/assets/css/plugins/cropper/cropper.css"/>

<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">

            <a href="{{ URL::route('gestor.__tabela__.edit', [$item->id]) }}?read=true"
               id="link-cancel-edit"
               data-toggle="tooltip" data-placement="top"
               title="Visualizar esse registro"
               class="btn btn-info">
                <i class="glyphicon glyphicon-eye-open"></i>
            </a>


            <a href="{{ URL::route('gestor.__tabela__.index') }}"
               id="link-index"
               data-toggle="tooltip" data-placement="top"
               title="Listar tudo"
               class="btn btn-primary link-index">
                <i class="glyphicon glyphicon-th-list"></i>
            </a>

        </div>
        <h3>__secao__</h3>
    </div>
</div>

@include('gestor._layouts.sessionMensagem')

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-picture"></i> Recorte na imagem
        </h3>
    </div>

    <div class="panel-body">
        {!! Form::open( [
                'route' => ['gestor.__tabela__.updateImageCrop', $item->id],
                'method' => 'put',
                'id' => 'form-destroy',
                'class' => 'form-horizontal',
                'autocomplete' => 'off',
                'role' => 'form'
            ]) !!}
        <div class="panel-body">

            <div>
                <img class="cropper"
                     src="{{ url('/') }}/images/__tabela__/original/{{ config('configuracoes.upload.__tabela__.tamanhoExibicaoDoCrop') }}/{{ $item->imagem }}"
                     alt="Picture">
            </div>

            <hr>

            <ul class="list-unstyled list-inline showcase-btn text-center">
                <li>
                    <button id="reset" type="button" class="btn btn-warning">Reset</button>
                </li>
                {{--<li>
                    <button id="reset2" type="button" class="btn  btn-warning">Reset (deep)</button>
                </li>--}}
                <li>
                    <button id="zoomIn" type="button" class="btn btn-info">Zoom In</button>
                </li>
                <li>
                    <button id="zoomOut" type="button" class="btn btn-info">Zoom Out</button>
                </li>
                <li>
                    <button type="submit" class="btn btn-success" id="btn_store">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Salvar
                    </button>
                </li>
                {{--<li>
                    <button id="rotateLeft" type="button" class="btn btn-info">Rotate Left</button>
                </li>
                <li>
                    <button id="rotateRight" type="button" class="btn btn-info">Rotate Right</button>
                </li>--}}
            </ul>
        </div>


        <div class="col-md-12" style="display: none">

            <div class="panel panel-default">
                <div class="panel-heading">Preview</div>
                <div class="panel-body">
                    <div class="preview preview-md"></div>
                    <div class="preview preview-sm"></div>
                    <div class="preview preview-xs"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Dados Atuais</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">X</span>
                                <input class="form-control" id="dataX" name="dataX" type="text" placeholder="x">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">Y</span>
                                <input class="form-control" id="dataY" name="dataY" type="text" placeholder="y">
                            </div>
                        </div>
                    </div>
                    <hr class="xs">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">W</span>
                                <input class="form-control" id="dataWidth" name="dataWidth" type="text"
                                       placeholder="width">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">H</span>
                                <input class="form-control" id="dataHeight" name="dataHeight" type="text"
                                       placeholder="height">
                            </div>
                        </div>
                    </div>
                    {{--<hr class="xs">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">Rotate</span>
                                <input class="form-control" id="dataRotate" name="dataRotate" type="text"
                                       placeholder="rotate">
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>--}}
                </div>
            </div>

        </div>
        {!! Form::hidden('imagem', $item->imagem) !!}
        {!! Form::hidden('ordemImagem', $ordemImagem) !!}
        {!! Form::hidden('aspectRatioConfig',
        config('configuracoes.upload.__tabela__.aspectRatio'),['id' => 'aspectRatioConfig']) !!}
        {!! Form::close() !!}


    </div>
</div>

@endsection

@section('scripts')
        <!-- Image Cropper -->

<script src="{{ url('/') }}/admin/assets/js/plugins/cropper/cropper-conf.js"></script>
<script src="{{ url('/') }}/admin/assets/js/plugins/cropper/cropper.min.js"></script>
<script>

    $(function () {

        /*$(".cropper").cropper({
         aspectRatio:
        {{ config('configuracoes.upload.__tabela__.aspectRatio') }},
         data: {
         x: 0,
         y: 0,
         width: 400,
         height: 400
         }
         });*/

        var $cropper = $(".cropper"),
                $dataX = $("#dataX"),
                $dataY = $("#dataY"),
                $dataHeight = $("#dataHeight"),
                $dataWidth = $("#dataWidth"),
                $dataRotate = $("#dataRotate"),
                console = window.console || {log: $.noop},
                cropper;

        $cropper.cropper({
            aspectRatio: {{ config('configuracoes.upload.__tabela__.aspectRatio') }},
            data: {
                x: 0,
                y: 0,
                width: {{ config('configuracoes.upload.__tabela__.widthSite') }},
                height: {{ config('configuracoes.upload.__tabela__.heightSite') }}



            },
            preview: ".preview",

            // autoCrop: false,
            // dragCrop: false,
            // modal: false,
            // moveable: false,
            // resizeable: false,
            // scalable: false,

            // maxWidth: 480,
            // maxHeight: 270,
            // minWidth: 160,
            // minHeight: 90,

            done: function (data) {
                $dataX.val(data.x);
                $dataY.val(data.y);
                $dataHeight.val(data.height);
                $dataWidth.val(data.width);
                $dataRotate.val(data.rotate);
            },
            build: function (e) {
                console.log(e.type);
            },
            built: function (e) {
                console.log(e.type);
            },
            dragstart: function (e) {
                console.log(e.type);
            },
            dragmove: function (e) {
                console.log(e.type);
            },
            dragend: function (e) {
                console.log(e.type);
            }
        });


    });

</script>
@endsection