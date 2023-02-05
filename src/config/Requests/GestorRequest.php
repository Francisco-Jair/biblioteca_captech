<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 04-11-2015
 * Time: 02:02:16
 */

namespace App\Http\Requests;

class GestorRequest extends Request
{

    /**
     * Regras de validação que se aplicam a solicitação padrão.
     *
     * @var array
     */
    protected $regras = [
        'nome' => 'required|max:255',
        'uid' => 'required|max:255',
        'email' => 'required|email|max:255|unique:gestores,email',
        'password' => 'required|confirmed|min:6',
        'passwordUpdate' => 'sometimes|confirmed|min:6',
        'isAdmin' => 'required|in:S,N',
    ];

    /**
     * Retorna as regras de validação que se aplicam a solicitação padrão.
     *
     * @return array
     */
    public function rules()
    {
        $id = Request::segment(3) ? ',' . Request::segment(3) : '';

        if ($id) {
            return [
                'nome' => $this->regras['nome'],
                'email' => $this->regras['email'] . $id,
                'password' => $this->regras['passwordUpdate'],
            ];
        }
        return [
            'nome' => $this->regras['nome'],
            'email' => $this->regras['email'] . $id,
            'password' => $this->regras['password'],
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