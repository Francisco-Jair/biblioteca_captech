<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:04:49
 */

namespace App\Services;

//use App\ImagemUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\LogLoginRequest;
use App\Repositories\LogLoginRepository;
//use ImagemUploadTraitService;

class LogLoginService
{
    /**
     * Instância de LogLoginRepository
     * @var LogLoginRepository
     */
    protected $logloginRepository;

    /**
     * Criar uma nova nova instância de LogLoginService
     * @param LogLoginRepository $logloginRepository
     */
    public function __construct(LogLoginRepository $logloginRepository)
    {
        $this->logloginRepository = $logloginRepository;
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

        //if ($request->query('loglogin'))
        //    $parametros['loglogin'] = $request->get('loglogin');

        return $this->logloginRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\LogLogin
     */
    public function find($id)
    {
        return $this->logloginRepository->find($id);
    }
    
    /**
     * Armazenar o novo registro no repositório de dados.
     * @param LogLoginRequest $logloginRequest
     * @return \App\Models\LogLogin
     */
    public function store(LogLoginRequest $logloginRequest)
    {
        $dados = $logloginRequest->all();

        return $this->logloginRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param LogLoginRequest $logloginRequest
     * @param int $id
     * @return \App\Models\LogLogin
     */
    public function update(
        LogLoginRequest $logloginRequest,
        $id)
    {
        $dados = $logloginRequest->all();

        return $this->logloginRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $loglogin = $this->logloginRepository->find($id);

        $logloginTemRegistros = $this->logloginRepository->logloginTemRegistros($loglogin);

        if ($logloginTemRegistros->count()) {
            $verificacao['loglogin'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $logloginTemRegistros];
        }

        return ['item' => $loglogin, 'verificacao' => $verificacao];
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
            if ($this->logloginRepository->destroy($item))
                $mensagem = 'Registro "' . $item->id . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->id . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de LogLogin para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->logloginRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }

}