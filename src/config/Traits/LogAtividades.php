<?php
/**
 * Created by PhpStorm.
 * User: rupertlustosa
 * Date: 12/04/15
 * Time: 21:05
 */

namespace App\Traits;

use App\Models\LogAtividade;

trait LogAtividades
{
    public function log($metodo)
    {
        if (!\Session::get('_devMode_')) {
            $log = new LogAtividade();

            if (\Session::get('_id_')) {
                $log->gestor_id = \Session::get('_id_');
            }

            $log->function = $metodo;
            $log->url = \Request::fullUrl();
            $log->request = json_encode(\Request::all());
            //$log->query = json_encode(\Request::query());
            $log->method = \Request::method();

            $log->save();
        }
    }
}