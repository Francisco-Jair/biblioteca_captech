<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 04-11-2015
 * Time: 02:02:16
 */

namespace App\Http\Requests;

class LogarRequest extends Request
{

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}