<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:04:49
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\LogLoginRequest;
use App\Services\LogLoginService;

class LogLoginController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de LogLoginService
     *
     * @var LogLoginService
     */
    protected $logloginService;

    /**
     * Criar uma nova nova instância de LogLoginController
     * @param LogLoginService $logloginService
     */
    public function __construct(LogLoginService $logloginService)
    {
        $this->log('acessou', __CLASS__, '');
        $this->logloginService = $logloginService;
        $this->service = 'logloginService';
        $this->pastaView = 'log_login';
    }


    /**
     * Exibir uma lista paginada de registros.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $camposPermitidosParaOrdenacao = ['id', 'created_at', 'updated_at'];
        $ordenacao['sort'] = 'id';
        $ordenacao['order'] = 'DESC';

        if ($request->query('sort') and in_array($request->query('sort'), $camposPermitidosParaOrdenacao)) {
            $ordenacao['sort'] = $request->query('sort');
        }

        if ($request->query('order')) {
            $ordenacao['order'] = ($request->query('order') == 'ASC' ? 'ASC' : 'DESC');
        }

        $ordenacao['reverseOrder'] = ($ordenacao['order'] == 'ASC' ? 'DESC' : 'ASC');

        $dados = $this->logloginService->index($request, $ordenacao);
        $dados->setPath('./log_login');
        return view('gestor.' . $this->pastaView . '.index', compact('dados', 'ordenacao'));
    }

    /**
     * Exibir um registro específico.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->logloginService->find($id);
        return view('gestor.' . $this->pastaView . '.form', compact('item'));
    }

    /**
     * Exibir o formulário para criar um novo registro.
     *
     * @return Response
     */
    public function create()
    {
        return $this->operacaoNaoPermitida();
    }

    /**
     * Armazenar o novo registro.
     *
     * @param LogLoginRequest $logloginRequest
     * @return Response
     */
    public function store(LogLoginRequest $logloginRequest)
    {
        return $this->operacaoNaoPermitida();
    }

    /**
     * Exibir um formulário de edição de um registro específico.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return $this->operacaoNaoPermitida();
    }

    /**
     * Atualizar um registro específico.
     *
     * @param LogLoginRequest $logloginRequest
     * @param int $id
     * @return Response
     */
    public function update(
        LogLoginRequest $logloginRequest,
        $id)
    {
        return $this->operacaoNaoPermitida();
    }
}
