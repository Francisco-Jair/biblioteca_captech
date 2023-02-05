<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 03:28:51
 */

namespace App\Http\Requests;

class ContatoRequest extends Request
{

    /**
     * Regras de validação que se aplicam a solicitação padrão.
     *
     * @var array
     */
    protected $regras = [
        'assunto_id' => 'required|exists:assuntos,id',
        'nome' => 'required|min:4|max:80',
        'email' => 'required|email',
        'telefone' => 'sometimes|min:4|max:80',
        'mensagem' => 'required',
        'ip' => 'required|min:4|max:80',
        'novo' => 'required|in:S,N',
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
            'assunto_id' => $this->regras['assunto_id'],
            'nome' => $this->regras['nome'],
            'email' => $this->regras['email'],
            'telefone' => $this->regras['telefone'],
            'mensagem' => $this->regras['mensagem'],
            #'ip' => $this->regras['ip'],
            #'novo' => $this->regras['novo'],
            'g-recaptcha-response' => 'required|recaptcha',
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