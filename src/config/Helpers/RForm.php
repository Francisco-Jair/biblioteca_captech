<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Helpers;

class RForm
{
    public static function FormAtivo($nome, $valor_atual)
    {
        if(is_null($valor_atual) ){
            $valor_atual = 1;
        }
        else if (!is_int($valor_atual)) {
            if ($valor_atual == 'Ativo')
                $valor_atual = 1;
            else $valor_atual = 0;
        }

        return \Form::select($nome,
            ['0' => 'Não Ativo', '1' => 'Ativo'],
            $valor_atual,
            [
                'data-placeholder' => 'Selecione um registro',
                'id' => $nome,
                'class' => 'form-control',
                'value' => \Input::old($nome)
            ]);
    }

    public static function FormAtivoBusca($nome, $valor_atual)
    {
        return \Form::select($nome,
            ['' => 'Todos', '0' => 'Não Ativo', '1' => 'Ativo'],
            $valor_atual,
            [
                'data-placeholder' => 'Selecione um registro',
                'id' => $nome,
                'class' => 'form-control',
                'value' => \Input::old($nome)
            ]);
    }

    public static function FormSimNao($nome, $valor_atual)
    {
        if(is_null($valor_atual) ){
            $valor_atual = 1;
        }
        else if (!is_int($valor_atual)) {
            if ($valor_atual == 'Sim')
                $valor_atual = 1;
            else $valor_atual = 0;
        }

        return \Form::select($nome,
            ['0' => 'Não', '1' => 'Sim'],
            $valor_atual,
            [
                'data-placeholder' => 'Selecione uma opção',
                'id' => $nome,
                'class' => 'form-control',
                'value' => \Input::old($nome)
            ]);
    }

    public static function FormSimNaoBusca($nome, $valor_atual)
    {
        return \Form::select($nome,
            ['' => 'Sim e Não', '0' => 'Não', '1' => 'Sim'],
            $valor_atual,
            [
                'data-placeholder' => 'Selecione uma opção',
                'id' => $nome,
                'class' => 'form-control',
                'value' => \Input::old($nome)
            ]);
    }
}