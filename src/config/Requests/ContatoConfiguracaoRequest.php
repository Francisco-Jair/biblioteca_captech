<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:13:49
 */

namespace App\Http\Requests;

class ContatoConfiguracaoRequest extends Request
{

    /**
     * Regras de validação que se aplicam a solicitação padrão.
     *
     * @var array
     */
    protected $regras = [
        'titulo' => 'required|min:6|max:255|unique:contato_configuracoes,titulo',
        'chave' => 'required|min:6|max:255|unique:contato_configuracoes,chave',
        'valor' => 'required|min:1|max:255',
    ];

    /**
     * Retorna as regras de validação que se aplicam a solicitação padrão.
     *
     * @return array
     */
    public function rules()
    {
        $id = Request::segment(3) ? ',' . Request::segment(3) : '';
        return [
            'titulo' => $this->regras['titulo'] . $id,
            'chave' => $this->regras['chave'] . $id,
            'valor' => $this->regras['valor'],
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