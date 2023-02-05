<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:00:05
 */

namespace App\Services;

//use App\ImagemUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\LogLoginErradoRequest;
use App\Repositories\LogLoginErradoRepository;
//use ImagemUploadTraitService;

class LogLoginErradoService
{
    /**
     * Instância de LogLoginErradoRepository
     * @var LogLoginErradoRepository
     */
    protected $logloginerradoRepository;

    /**
     * Criar uma nova nova instância de LogLoginErradoService
     * @param LogLoginErradoRepository $logloginerradoRepository
     */
    public function __construct(LogLoginErradoRepository $logloginerradoRepository)
    {
        $this->logloginerradoRepository = $logloginerradoRepository;
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

        //if ($request->query('logloginerrado'))
        //    $parametros['logloginerrado'] = $request->get('logloginerrado');

        return $this->logloginerradoRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\LogLoginErrado
     */
    public function find($id)
    {
        return $this->logloginerradoRepository->find($id);
    }
    
    /**
     * Armazenar o novo registro no repositório de dados.
     * @param LogLoginErradoRequest $logloginerradoRequest
     * @return \App\Models\LogLoginErrado
     */
    public function store(LogLoginErradoRequest $logloginerradoRequest)
    {
        $dados = $logloginerradoRequest->all();

        return $this->logloginerradoRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param LogLoginErradoRequest $logloginerradoRequest
     * @param int $id
     * @return \App\Models\LogLoginErrado
     */
    public function update(
        LogLoginErradoRequest $logloginerradoRequest,
        $id)
    {
        $dados = $logloginerradoRequest->all();

        return $this->logloginerradoRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $logloginerrado = $this->logloginerradoRepository->find($id);

        $logloginerradoTemRegistros = $this->logloginerradoRepository->logloginerradoTemRegistros($logloginerrado);

        if ($logloginerradoTemRegistros->count()) {
            $verificacao['logloginerrado'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $logloginerradoTemRegistros];
        }

        return ['item' => $logloginerrado, 'verificacao' => $verificacao];
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
            if ($this->logloginerradoRepository->destroy($item))
                $mensagem = 'Registro "' . $item->id . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->id . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de LogLoginErrado para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->logloginerradoRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }

}