<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:07:00
 */

namespace App\Services;

//use App\ImagemUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\LogAtividadeRequest;
use App\Repositories\LogAtividadeRepository;
//use ImagemUploadTraitService;

class LogAtividadeService
{
    /**
     * Instância de LogAtividadeRepository
     * @var LogAtividadeRepository
     */
    protected $logatividadeRepository;

    /**
     * Criar uma nova nova instância de LogAtividadeService
     * @param LogAtividadeRepository $logatividadeRepository
     */
    public function __construct(LogAtividadeRepository $logatividadeRepository)
    {
        $this->logatividadeRepository = $logatividadeRepository;
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
        if ($request->query('id'))
            $parametros['id'] = (int)$request->get('id');

        if ($request->query('termo'))
            $parametros['termo'] = trim($request->get('termo'));

        if ($request->query('sort'))
            $parametros['sort'] = $request->get('sort');

        //if ($request->query('logatividade'))
        //    $parametros['logatividade'] = $request->get('logatividade');

        return $this->logatividadeRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\LogAtividade
     */
    public function find($id)
    {
        return $this->logatividadeRepository->find($id);
    }
    
    /**
     * Armazenar o novo registro no repositório de dados.
     * @param LogAtividadeRequest $logatividadeRequest
     * @return \App\Models\LogAtividade
     */
    public function store(LogAtividadeRequest $logatividadeRequest)
    {
        $dados = $logatividadeRequest->all();

        return $this->logatividadeRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param LogAtividadeRequest $logatividadeRequest
     * @param int $id
     * @return \App\Models\LogAtividade
     */
    public function update(
        LogAtividadeRequest $logatividadeRequest,
        $id)
    {
        $dados = $logatividadeRequest->all();

        return $this->logatividadeRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $logatividade = $this->logatividadeRepository->find($id);

        $logatividadeTemRegistros = $this->logatividadeRepository->logatividadeTemRegistros($logatividade);

        if ($logatividadeTemRegistros->count()) {
            $verificacao['logatividade'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $logatividadeTemRegistros];
        }

        return ['item' => $logatividade, 'verificacao' => $verificacao];
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
            if ($this->logatividadeRepository->destroy($item))
                $mensagem = 'Registro "' . $item->id . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->id . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de LogAtividade para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->logatividadeRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }

}