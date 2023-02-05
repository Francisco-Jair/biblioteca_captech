<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:39:08
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\AssuntoRequest;
use App\Services\AssuntoService;

class AssuntoController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de AssuntoService
     *
     * @var AssuntoService
     */
    protected $assuntoService;

    /**
     * Criar uma nova nova instância de AssuntoController
     * @param AssuntoService $assuntoService
     */
    public function __construct(AssuntoService $assuntoService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->assuntoService = $assuntoService;
        $this->service = 'assuntoService';
        $this->pastaView = 'assuntos';
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

        $dados = $this->assuntoService->index($request, $ordenacao);
        $dados->setPath('./assuntos');
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
        $item = $this->assuntoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Exibir o formulário para criar um novo registro.
     *
     * @return Response
     */
    public function create()
    {
        //$options_assuntos_id = $this->assuntoService->listBox();
        return view('gestor.'.$this->pastaView.'.form');
    }

    /**
     * Armazenar o novo registro.
     *
     * @param AssuntoRequest $assuntoRequest
     * @return Response
     */
    public function store(AssuntoRequest $assuntoRequest)
    {
        $this->assuntoService->store($assuntoRequest);
        return redirect()->route('gestor.'.$this->pastaView.'.index')
            ->with('mensagem', 'Salvo com sucesso')
            ->with('tipo_mensagem', 'success');
    }

    /**
     * Exibir um formulário de edição de um registro específico.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //$options_assuntos_id = $this->assuntoService->listBox();
        $item = $this->assuntoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Atualizar um registro específico.
     *
     * @param AssuntoRequest $assuntoRequest
     * @param int $id
     * @return Response
     */
    public function update(
        AssuntoRequest $assuntoRequest,
        $id)
    {
        $this->assuntoService->update($assuntoRequest, $id);
        return redirect()->route('gestor.'.$this->pastaView.'.index')
            ->with('mensagem', 'Atualizado com sucesso')
            ->with('tipo_mensagem', 'success');
    }
}
