<?php namespace App\Presenters;

trait BooleanAtivoPresenter
{
    /**
     * Format ativo attribute
     * @param $ativo
     * @return string
     * @throws \Exception
     */
    public function getAtivoAttribute($ativo)
    {
        if ($ativo == 0)
            return 'Não ativo';
        else if ($ativo == 1)
            return 'Ativo';
        else throw new \Exception('ValorInvalidoParaAtributoAtivo');
    }
}