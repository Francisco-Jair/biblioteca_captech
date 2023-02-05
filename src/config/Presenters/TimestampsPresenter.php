<?php namespace App\Presenters;

use Carbon\Carbon;

trait TimestampsPresenter
{
    /**
     * Format created_at attribute
     *
     * @param Carbon $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        if ($date == '0000-00-00 00:00:00' or empty($date))
            return '';
        return Carbon::parse($date)->format($this->getFormatDateTime());
    }


    /**
     * Format updated_at attribute
     *
     * @param Carbon $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        if ($date == '0000-00-00 00:00:00' or empty($date))
            return '';
        return Carbon::parse($date)->format($this->getFormatDateTime());
    }

    /**
     * Format date
     *
     * @return string
     */
    private function getFormatDateTime()
    {
        return config('app.locale') == 'pt-BR' ? 'd/m/Y H:i' : 'm-d-Y H:i';
    }
}