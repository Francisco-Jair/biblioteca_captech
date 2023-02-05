<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:00:04
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\LogLoginErradoRequest;
use App\Services\LogLoginErradoService;

class LogLoginErradoController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de LogLoginErradoService
     *
     * @var LogLoginErradoService
     */
    protected $logloginerradoService;

    /**
     * Criar uma nova nova instância de LogLoginErradoController
     * @param LogLoginErradoService $logloginerradoService
     */
    public function __construct(LogLoginErradoService $logloginerradoService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->logloginerradoService = $logloginerradoService;
        $this->service = 'logloginerradoService';
        $this->pastaView = 'log_login_errado';
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

        $dados = $this->logloginerradoService->index($request, $ordenacao);
        $dados->setPath('./log_login_errado');
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
        $item = $this->logloginerradoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
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
     * @param LogLoginErradoRequest $logloginerradoRequest
     * @return Response
     */
    public function store(LogLoginErradoRequest $logloginerradoRequest)
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
     * @param LogLoginErradoRequest $logloginerradoRequest
     * @param int $id
     * @return Response
     */
    public function update(
        LogLoginErradoRequest $logloginerradoRequest,
        $id)
    {
        return $this->operacaoNaoPermitida();
    }
}
