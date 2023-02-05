<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 03:28:50
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ContatoRequest;
use App\Repositories\ContatoRepository;

class ContatoService
{
    /**
     * Instância de ContatoRepository
     * @var ContatoRepository
     */
    protected $contatoRepository;

    /**
     * Criar uma nova nova instância de ContatoService
     * @param ContatoRepository $contatoRepository
     */
    public function __construct(ContatoRepository $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    /**
     * Exibir uma lista de registros
     * @param Request $request
     * @param array $ordenacao
     * @return array
     */
    public function index(Request $request, $ordenacao)
    {
        $parametros = [];
        if ($request->query('sort'))
            $parametros['sort'] = $request->get('sort');

        if ($request->query('id'))
            $parametros['id'] = (int)$request->get('id');

        if ($request->query('termo'))
            $parametros['termo'] = trim($request->get('termo'));

        if ($request->query('assunto_id'))
            $parametros['assunto_id'] = (int)$request->get('assunto_id');

        return $this->contatoRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\Contato
     */
    public function find($id)
    {
        return $this->contatoRepository->find($id);
    }

    /**
     * Armazenar o novo registro no repositório de dados.
     * @param ContatoRequest $contatoRequest
     * @return \App\Models\Contato
     */
    public function store(ContatoRequest $contatoRequest)
    {
        $user = new \stdClass();
        $user->email = 'rupertlustosa@gmail.com';
        $user->name = 'Rupert Lustosa';


        \Mail::send('emails.novo-contato', ['dados' => $contatoRequest->all()], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Gênesis Informa :: Novo Recado')
                ->from('rupertlustosa@gmail.com', 'Gênesis Centrocar')
                ->sender('rupertlustosa@gmail.com', 'Gênesis Centrocar');

            $listaEmailsParaEnvio = [];

            $enviarPara = \App\Models\Configuracao::select('valor')->where('titulo', 'emails-para-enviar-o-contato')->first();
            if ($enviarPara->valor) {
                $partes = explode(',', $enviarPara->valor);
                if (count($partes)) {
                    foreach ($partes as $email) {
                        $listaEmailsParaEnvio[] = $email;
                    }
                } else {
                    $listaEmailsParaEnvio[] = $enviarPara;
                }

                foreach ($listaEmailsParaEnvio as $email)
                    $m->cc($email);
            }
        });

        return $this->contatoRepository->store($contatoRequest->all());
    }

    /**
     * Atualizar o registro especificado.
     * @param ContatoRequest $contatoRequest
     * @param int $id
     * @return \App\Models\Contato
     */
    public function update(
        ContatoRequest $contatoRequest,
        $id)
    {
        $dados = $contatoRequest->all();

        return $this->contatoRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $contato = $this->contatoRepository->find($id);

        $contatoTemRegistros = $this->contatoRepository->contatoTemRegistros($contato);

        if ($contatoTemRegistros->count()) {
            $verificacao['contato'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $contatoTemRegistros];
        }

        return ['item' => $contato, 'verificacao' => $verificacao];
    }

    /**
     * Excluir um registro.
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function destroy($id)
    {
        $response = $this->confirmDestroy($id);
        $item = $response['item'];
        $verificacao = $response['verificacao'];

        if (count($verificacao) == 0) {
            if ($this->contatoRepository->destroy($item))
                $mensagem = 'Registro "' . $item->nome . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->nome . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de Contato para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->contatoRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }

    public function marcaComoLido($id)
    {
        return $this->contatoRepository->marcaComoLido($id);
    }
}