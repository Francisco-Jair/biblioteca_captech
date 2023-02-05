<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:48:44
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\GestorRequest;
use App\Repositories\GestorRepository;

class GestorService
{
    /**
     * Instância de GestorRepository
     * @var GestorRepository
     */
    protected $gestorRepository;

    /**
     * Criar uma nova nova instância de GestorService
     * @param GestorRepository $gestorRepository
     */
    public function __construct(GestorRepository $gestorRepository)
    {
        $this->gestorRepository = $gestorRepository;
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

        if ($request->query('gestor'))
            $parametros['gestor'] = $request->get('gestor');
        return $this->gestorRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\Gestor
     */
    public function find($id)
    {
        return $this->gestorRepository->find($id);
    }

    /**
     * Armazenar o novo registro no repositório de dados.
     * @param GestorRequest $gestorRequest
     * @return \App\Models\Gestor
     */
    public function store(GestorRequest $gestorRequest)
    {
        $dados = $gestorRequest->all();

        return $this->gestorRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param GestorRequest $gestorRequest
     * @param int $id
     * @return \App\Models\Gestor
     */
    public function update(
        GestorRequest $gestorRequest,
        $id)
    {
        $dados = $gestorRequest->all();

        return $this->gestorRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $gestor = $this->gestorRepository->find($id);

        $gestorTemRegistros = $this->gestorRepository->gestorTemRegistros($gestor);

        if ($gestorTemRegistros->count()) {
            $verificacao['gestor'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $gestorTemRegistros];
        }

        return ['item' => $gestor, 'verificacao' => $verificacao];
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
            if ($this->gestorRepository->destroy($item))
                $mensagem = 'Registro "' . $item->nome . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->nome . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de Gestor para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->gestorRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }
}