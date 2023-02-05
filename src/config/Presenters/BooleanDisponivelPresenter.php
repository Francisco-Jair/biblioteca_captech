<?php namespace App\Presenters;

trait BooleanDisponivelPresenter
{
    /**
     * Format ativo attribute
     * @param $ativo
     * @return string
     * @throws \Exception
     */
    public function getDisponivelAttribute($ativo)
    {
        if ($ativo == 0)
            return 'Não ativo';
        else if ($ativo == 1)
            return 'Disponivel';
        else throw new \Exception('ValorInvalidoParaAtributoDisponivel');
    }
}