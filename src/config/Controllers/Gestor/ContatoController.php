<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 03:28:49
 */

namespace App\Http\Controllers\Gestor;

use App\Services\AssuntoService;
use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\ContatoRequest;
use App\Services\ContatoService;

class ContatoController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de ContatoService
     *
     * @var ContatoService
     */
    protected $contatoService;
    /**
     * @var AssuntoService
     */
    protected $assuntoService;

    /**
     * Criar uma nova nova instância de ContatoController
     * @param ContatoService $contatoService
     * @param AssuntoService $assuntoService
     */
    public function __construct(ContatoService $contatoService, AssuntoService $assuntoService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->contatoService = $contatoService;
        $this->service = 'contatoService';
        $this->assuntoService = $assuntoService;
        $this->pastaView = 'contatos';
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

        $dados = $this->contatoService->index($request, $ordenacao);
        $dados->setPath('./contatos');
        $options_assunto_id = $this->assuntoService->listBoxGestor();
        return view('gestor.' . $this->pastaView . '.index', compact('dados', 'ordenacao', 'options_assunto_id'));
    }

    /**
     * Exibir um registro específico.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->contatoService->find($id);
        $this->contatoService->marcaComoLido($id);
        $options_assunto_id = $this->assuntoService->listBoxGestor();
        return view('gestor.'.$this->pastaView.'.form', compact('item', 'options_assunto_id'));
    }

    /**
     * Exibir o formulário para criar um novo registro.
     *
     * @return Response
     */
    public function create()
    {
        $options_assunto_id = $this->assuntoService->listBoxGestor();
        return view('gestor.'.$this->pastaView.'.form', compact('item', 'options_assunto_id'));
    }

    /**
     * Armazenar o novo registro.
     *
     * @param ContatoRequest $contatoRequest
     * @return Response
     */
    public function store(ContatoRequest $contatoRequest)
    {
        $this->contatoService->store($contatoRequest);
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
        $options_assunto_id = $this->assuntoService->listBoxGestor();
        $item = $this->contatoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item', 'options_assunto_id'));
    }

    /**
     * Atualizar um registro específico.
     *
     * @param ContatoRequest $contatoRequest
     * @param int $id
     * @return Response
     */
    public function update(
        ContatoRequest $contatoRequest,
        $id)
    {
        $this->contatoService->update($contatoRequest, $id);
        return redirect()->route('gestor.'.$this->pastaView.'.index')
            ->with('mensagem', 'Atualizado com sucesso')
            ->with('tipo_mensagem', 'success');
    }
}
