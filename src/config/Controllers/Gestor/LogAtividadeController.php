<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:07:00
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\LogAtividadeRequest;
use App\Services\LogAtividadeService;

class LogAtividadeController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de LogAtividadeService
     *
     * @var LogAtividadeService
     */
    protected $logatividadeService;

    /**
     * Criar uma nova nova instância de LogAtividadeController
     * @param LogAtividadeService $logatividadeService
     */
    public function __construct(LogAtividadeService $logatividadeService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->logatividadeService = $logatividadeService;
        $this->service = 'logatividadeService';
        $this->pastaView = 'log_atividades';
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

        $dados = $this->logatividadeService->index($request, $ordenacao);
        $dados->setPath('./log_atividades');
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
        $item = $this->logatividadeService->find($id);
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
     * @param LogAtividadeRequest $logatividadeRequest
     * @return Response
     */
    public function store(LogAtividadeRequest $logatividadeRequest)
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
     * @param LogAtividadeRequest $logatividadeRequest
     * @param int $id
     * @return Response
     */
    public function update(
        LogAtividadeRequest $logatividadeRequest,
        $id)
    {
        return $this->operacaoNaoPermitida();
    }
}
