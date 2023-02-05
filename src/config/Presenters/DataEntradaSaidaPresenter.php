<?php namespace App\Presenters;

use Carbon\Carbon;

trait DataEntradaSaidaPresenter
{

    /**
     * Format data_entrada attribute
     *
     * @param Carbon $date
     * @return string
     */
    public function getDataEntradaAttribute($date)
    {
        if ($date == '0000-00-00' or empty($date))
            return '';
        return Carbon::parse($date)->format($this->getFormatDate());
    }

    public function setDataEntradaAttribute($date)
    {
        if (empty($date))
            $this->attributes['data_entrada'] = null;
        else {
            // 30/12/2015
            $dia = substr($date, 0, 2);
            $mes = substr($date, 3, 2);
            $ano = substr($date, 6, 4);

            $this->attributes['data_entrada'] = Carbon::createFromDate($ano, $mes, $dia);
        }
    }

    /**
     * Format data_saida attribute
     *
     * @param Carbon $date
     * @return string
     */
    public function getDataSaidaAttribute($date)
    {
        if ($date == '0000-00-00' or empty($date))
            return '';
        return Carbon::parse($date)->format($this->getFormatDate());
    }

    public function setDataSaidaAttribute($date)
    {
        if (empty($date))
            $this->attributes['data_saida'] = null;
        else {
            $dia = substr($date, 0, 2);
            $mes = substr($date, 3, 2);
            $ano = substr($date, 6, 4);

            $this->attributes['data_saida'] = Carbon::createFromDate($ano, $mes, $dia);
        }
    }

    /**
     * Format date
     *
     * @return string
     */
    private function getFormatDate()
    {
        return config('app.locale') == 'pt-BR' ? 'd/m/Y' : 'm-d-Y';
    }

}