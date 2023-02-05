<?php namespace Rupertlustosa\Rlustosa;

/**
 * Created by PhpStorm.
 * User: rupertlustosa
 * Date: 19/12/14
 * Time: 17:34
 */


class RlustosaGenerate
{
    public function describe($tabela)
    {
        $camposDaTabela = [];

        $describe = \DB::select('describe ' . $tabela . ';');
        foreach ($describe as $registro) {
            $tipo = preg_replace("/^(.+)\(.+$/", "$1", $registro->Type);

            $camposDaTabela[] = array('campo' => camel_case($registro->Field), 'campo_original' => trim($registro->Field),
                'tipo' => $tipo,
                'key' => ($registro->Key == 'PRI' ? 'primaria' : ($registro->Key == 'MUL' ? 'estrangeira' : null)),
                'aceita_nulo' => ($registro->Null == 'NO' ? 'N' : ($registro->Null == 'YES' ? 'S' : null)),
                'entreParentesis' => $this->conteudoEntreParentesis($registro->Type)
            );
        }
        return $camposDaTabela;
    }

    public function retornaRelacionamentos($banco, $tabela, $campo)
    {
        $relacionamento = \DB::select("
        select
            REPLACE(FOR_NAME,'{$banco}/','') as tabela,
            REPLACE(REPLACE(REPLACE(ID,'_foreign',''),'{$banco}/','')    ,   concat(REPLACE(FOR_NAME,'{$banco}/',''),'_'), ''    ) as chave,
            #REPLACE(REPLACE(ID,'_foreign',''),'{$banco}/','') as chave,
            REPLACE(REF_NAME,'{$banco}/','') as referencia
            from information_schema.INNODB_SYS_FOREIGN where FOR_NAME like '{$banco}/%'
            and REPLACE(FOR_NAME,'{$banco}/','') = '{$tabela}'
            and REPLACE(REPLACE(REPLACE(ID,'_foreign',''),'{$banco}/','')    ,   concat(REPLACE(FOR_NAME,'{$banco}/',''),'_'), ''    ) = '{$campo}'
            order by tabela asc;
        ");
        if (isset($relacionamento[0]))
            return $relacionamento[0];
        else {
            return null;
        }
    }

    public function gerarIndexSearch($campos)
    {
        return '
                        {{--<div class="form-group">
                            <label for="' . $campos['nomeCampo'] . '" class="col-sm-2 control-label">' . $campos['label'] . ' </label>

                            {!! Form::text(\'' . $campos['nomeCampo'] . '\', ( \Request::query(\'' . $campos['nomeCampo'] . '\') ? \Request::query(\'' . $campos['nomeCampo'] . '\') : null),
                                [
                                    \'class\'=>\'form-control\',
                                    \'id\' => \'' . $campos['nomeCampo'] . '\',
                                    \'placeholder\'=>\'\',
                                    \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                                ]
                            ) !!}
                        </div>--}}
                        ';
    }

    public function gerarIndexList($campos, $tabela)
    {
        if ($campos['nomeCampo'] == 'id')
            $thead = '                            <th style="width: 70px">{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, \'id\', \'#ID\') !!}</th>';
        else if ($campos['nomeCampo'] == 'created_at' or $campos['nomeCampo'] == 'updated_at')
            $thead = '                            <th>{!! HeaderPaginacao::MontaLinksHeaderPaginacao($ordenacao, \'' . $campos['nomeCampo'] . '\', \'' . $campos['label'] . '\') !!}</th>';
        else
            $thead = '                            <th>' . $campos['label'] . '</th>';

        if (substr($campos['nomeCampo'], 0, 6) == 'imagem') {
            if (!empty(substr($campos['nomeCampo'], 6, 1)))
                $ordemDaFoto = substr($campos['nomeCampo'], 6, 1);
            else $ordemDaFoto = 'null';

            $thead = '                            <th class="text-center">' . $campos['label'] . '</th>';
            $tbody = '
                                <td class="text-center">
                                    @if($item->' . $campos['nomeCampo'] . ')
                                        <a href="{{ URL::route(\'gestor.' . $tabela . '.imageCrop\', [$item->id, ' . $ordemDaFoto . ']) }}">
                                            <img src="{{ url(\'/\') }}/images/' . $tabela . '/100/{{ $item->' . $campos['nomeCampo'] . ' }}">
                                            <br/>
                                            <i class="fa fa-crop"></i>
                                            Editar
                                        </a>
                                        |
                                        <a href="{{ URL::route(\'gestor.' . $tabela . '.imageDestroy\', [$item->id, ' . $ordemDaFoto . ']) }}"
                                           onclick="if(confirm(\'Confirma exclusão dessa imagem?\')) return true; else return false;">
                                            Remover
                                        </a>
                                    @endif
                                </td>
            ';
        } else
            $tbody = '                                <td>{{$item->' . $campos['nomeCampo'] . '}}</td>';
        return ['thead' => $thead, 'tbody' => $tbody];
    }

    public function gerarRules($camposDaTabela, $tabela, $database)
    {
        $regras = [];
        foreach ($camposDaTabela as $campo) {

            if ($campo['campo_original'] == 'id' or $campo['campo_original'] == 'created_at' or $campo['campo_original'] == 'updated_at' or $campo['campo_original'] == 'deleted_at')
                continue;

            //print_r('tipo = ' . $campo['tipo'].' -- aceita_nulo = '.$campo['aceita_nulo'] . ' --- key '.$campo['key']);

            if ($campo['tipo'] == 'varchar') {
                if (substr($campo['campo_original'], 0, 6) == 'imagem') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'required|image',";
                    $regras[] = "'" . $campo['campo_original'] . "Update' => 'sometimes|image',";
                } else if ($campo['campo_original'] == 'email') {
                    if ($campo['aceita_nulo'] == 'N') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'required|email',";
                    } else if ($campo['aceita_nulo'] == 'S') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|email',";
                    }
                } else if ($campo['campo_original'] == 'url') {
                    if ($campo['aceita_nulo'] == 'N') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'required|url',";
                    } else if ($campo['aceita_nulo'] == 'S') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|url',";
                    }
                } else {
                    if ($campo['aceita_nulo'] == 'N') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'required|min:5|max:255',";
                    } else if ($campo['aceita_nulo'] == 'S') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|min:5|max:255',";
                    }
                }
            } else if ($campo['tipo'] == 'int') {
                if ($campo['key'] == 'primaria') {
                    //$regras[] = "'".$campo['campo_original']."' => 'required|integer|between:1,999999999',";
                } else if ($campo['key'] == 'estrangeira') {
                    $dadosForeignKey = $this->retornaRelacionamentos($database, $tabela, $campo['campo_original']);
                    if (isset($dadosForeignKey->referencia))
                        $regras[] = "'" . $campo['campo_original'] . "' => 'required|exists:" . $dadosForeignKey->referencia . ",id',";
                } else {
                    if ($campo['aceita_nulo'] == 'N') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'required|integer|between:1,4294967295',";
                    } else if ($campo['aceita_nulo'] == 'S') {
                        $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|integer|between:1,4294967295',";
                    }
                }
            } else if ($campo['tipo'] == 'date') {
                if ($campo['aceita_nulo'] == 'N') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'required|date_format:d/m/Y',";
                } else if ($campo['aceita_nulo'] == 'S') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|date_format:d/m/Y',";
                }
            } else if ($campo['tipo'] == 'datetime' or $campo['tipo'] == 'timestamp') {
                if ($campo['aceita_nulo'] == 'N') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'required|date_format:d/m/Y H:i',";
                } else if ($campo['aceita_nulo'] == 'S') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|date_format:d/m/Y H:i',";
                }
            } else if ($campo['tipo'] == 'enum') {
                if ($campo['aceita_nulo'] == 'N') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'required|in:" . $campo['entreParentesis'] . "',";
                } else if ($campo['aceita_nulo'] == 'S') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes|in:" . $campo['entreParentesis'] . "',";
                }
            } else {
                if ($campo['aceita_nulo'] == 'N') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'required',";
                } else if ($campo['aceita_nulo'] == 'S') {
                    $regras[] = "'" . $campo['campo_original'] . "' => 'sometimes',";
                } else {
                    $regras[] = "'" . $campo['campo_original'] . "' => '???????????????',";
                }
            }

            $rules[] = '\'' . $campo['campo_original'] . '\' => $this->regras[\'' . $campo['campo_original'] . '\'],';
        }
        return ['regras' => $regras, 'rules' => $rules];
    }

    public function gerarFormList($campos, $tabela)
    {

        $retorno = '
                <div class="form-group {{ $errors->has(\'' . $campos['nomeCampo'] . '\') ? \'has-error has-feedback\' : \'\' }}">
                    <label class="col-sm-2 control-label">' . $campos['label'] . ' <span class="obrigatorio">*</span></label>

                    <div class="col-sm-7">
                        @if  (\Request::query(\'read\'))';


        if (substr($campos['nomeCampo'], 0, 6) == 'imagem') {
            if (!empty(substr($campos['nomeCampo'], 6, 1)))
                $ordemDaFoto = substr($campos['nomeCampo'], 6, 1);
            else $ordemDaFoto = 'null';

            $retorno .= '
                            <p class="form-control-static">
                                @if($item->' . $campos['nomeCampo'] . ')
                                    <a href="{{ URL::route(\'gestor.' . $tabela . '.imageCrop\', [$item->id, ' . $ordemDaFoto . ']) }}">
                                        <img src="{{ url(\'/\') }}/images/' . $tabela . '/200/{{ $item->' . $campos['nomeCampo'] . ' }}">
                                        <br/>
                                        <i class="fa fa-crop"></i>
                                        Editar
                                    </a>
                                @endif
                            </p>
                        @else
            ';
        } else
            $retorno .= '
                            <p class="form-control-static">{!! ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null) !!}</p>
                        @else';


        if (substr($campos['nomeCampo'], -3) == '_id') {
            $retorno .= '
                            {!! Form::select(\'' . $campos['nomeCampo'] . '\',
                                ( isset($options_' . $campos['nomeCampo'] . ') ? $options_' . $campos['nomeCampo'] . ' : [\'0\'=>\'Implemente $options_' . $campos['nomeCampo'] . '\']),
                                ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                                [
                                    \'data-placeholder\' => \'Selecione um registro\',
                                    \'class\'=>\'form-control chosen-select-deselect\',
                                    \'id\' => \'' . $campos['nomeCampo'] . '\',
                                    \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                                ]
                            ) !!}
                            ';
        }
        else if ($campos['nomeCampo'] == 'ativo') {
            $retorno .= '
                            {!! RForm::FormAtivo(\'ativo\',( isset($item->ativo) ? $item->ativo : null)) !!}
                            ';
        } else if ($campos['tipoDoCampo'] == 'date') {
            $retorno .= '
                            <div class="input-group date" id="datepicker">
                            <!-- datepicker timepicker datetimepicker datetimerangepicker1 datetimerangepicker2-->
                                {!! Form::text(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                                [
                                    \'placeholder\'=>\'dd/mm/yyyy\',
                                    \'data-date-format\' => \'DD/MM/YYYY\',
                                    \'data-inputmask\' => "\'alias\': \'dd/mm/yyyy\'",
                                    \'class\'=>\'form-control inputmask\',
                                    \'id\' => \'' . $campos['nomeCampo'] . '\',
                                    \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                                ]
                                ) !!}
                                <span class="input-group-addon"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
            ';
        } else if ($campos['tipoDoCampo'] == 'time') {
            $retorno .= '
                            <div class="input-group date" id="timepicker">
                            <!-- datepicker timepicker datetimepicker datetimerangepicker1 datetimerangepicker2-->
                                {!! Form::text(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                                [
                                    \'placeholder\'=>\'hh:mm\',
                                    \'data-date-format\' => \'HH:mm\',
                                    \'data-inputmask\' => "\'alias\': \'hh:mm\'",
                                    \'class\'=>\'form-control inputmask\',
                                    \'id\' => \'' . $campos['nomeCampo'] . '\',
                                    \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                                ]
                                ) !!}
                                <span class="input-group-addon"><span
                                            class="glyphicon glyphicon-time"></span></span>
                            </div>
            ';
        } else if ($campos['tipoDoCampo'] == 'datetime') {
            $retorno .= '
                            <div class="input-group date" id="datetimepicker">
                            <!-- datepicker timepicker datetimepicker datetimerangepicker1 datetimerangepicker2-->
                                {!! Form::text(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                                [
                                   \'placeholder\'=>\'dd/mm/yyyy hh:mm\',
                                    \'data-date-format\' => \'DD/MM/YYYY HH:mm\',
                                    \'class\'=>\'form-control\',
                                    \'id\' => \'' . $campos['nomeCampo'] . '\',
                                    \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                                ]
                                ) !!}
                                <span class="input-group-addon"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
            ';
        } else if ($campos['tipoDoCampo'] == 'text') {
            $retorno .= '
                            {!! Form::textarea(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                            [
                                \'class\'=>\'form-control\',
                                \'id\' => \'' . $campos['nomeCampo'] . '\',
                                \'size\' => \'30x5\',
                                #\'maxlength\' => \'255\',
                                \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                            ]
                            ) !!}
            ';
        } else if (substr($campos['nomeCampo'], 0, 6) == 'imagem') {
            $retorno .= '
                            {!! Form::file(\'' . $campos['nomeCampo'] . '\', [\'id\' => \'' . $campos['nomeCampo'] . '\']) !!}
                            <small>Faça upload de uma imagem JPEG ou PNG preferencialmente
                                de {{-- config(\'configuracoes.upload.' . $tabela . '.widthSite\') --}}
                                x {{-- config(\'configuracoes.upload.' . $tabela . '.heightSite\') --}} pixels de no
                                máximo {{ ini_get(\'post_max_size\') }}</small>
            ';
        } else if ($campos['tipoDoCampo'] == 'integer') {
            $retorno .= '
                            {!! Form::number(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                            [
                                \'placeholder\'=>\'\',
                                \'class\'=>\'form-control\',
                                \'id\' => \'' . $campos['nomeCampo'] . '\',
                                \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                            ]
                            ) !!}
            ';
        } else {
            $retorno .= '
                            {!! Form::text(\'' . $campos['nomeCampo'] . '\', ( isset($item->' . $campos['nomeCampo'] . ') ? $item->' . $campos['nomeCampo'] . ' : null),
                            [
                                \'placeholder\'=>\'\',
                                \'class\'=>\'form-control\',
                                \'id\' => \'' . $campos['nomeCampo'] . '\',
                                \'value\'=>Input::old(\'' . $campos['nomeCampo'] . '\')
                            ]
                            ) !!}
            ';
        }

        $retorno .= '
                            {!! $errors->first(\'' . $campos['nomeCampo'] . '\',\'<span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span class="help-block"><small>:message</small></span>\') !!}
                        @endif
                    </div>
                </div>
    ';
        return $retorno;
    }

    public function conteudoEntreParentesis($Type)
    {
        $conteudo = NULL;
        $partes = explode('(', $Type);
        if (count($partes) > 1) {
            $partes = explode(')', $partes[1]);
            $conteudo = str_replace("'", "", $partes[0]);
        }
        return $conteudo;
    }
}