<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 04:09:07
 */

namespace App\Http\Requests;

class LogLoginErradoRequest extends Request
{

    /**
     * Regras de validação que se aplicam a solicitação padrão.
     *
     * @var array
     */
    protected $regras = [
        'data' => 'required|date_format:d/m/Y H:i',
        'ip' => 'required|min:5|max:255',
        'login' => 'required|min:5|max:255',
        'senha' => 'sometimes|min:5|max:255',
    ];

    /**
     * Retorna as regras de validação que se aplicam a solicitação padrão.
     *
     * @return array
     */
    public function rules()
    {
        //$id = Request::segment(3) ? ',' . Request::segment(3) : '';
        return [
            'data' => $this->regras['data'],
            'ip' => $this->regras['ip'],
            'login' => $this->regras['login'],
            'senha' => $this->regras['senha'],
        ];
    }

    /**
     * Determine se o usuário está autorizado a fazer este pedido.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Enviar mensagens customizadas para os erros de validação.
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}