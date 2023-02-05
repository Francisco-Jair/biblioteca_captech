<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:13:36
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\ContatoConfiguracaoRequest;
use App\Services\ContatoConfiguracaoService;

class ContatoConfiguracaoController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de ContatoConfiguracaoService
     *
     * @var ContatoConfiguracaoService
     */
    protected $contatoconfiguracaoService;

    /**
     * Criar uma nova nova instância de ContatoConfiguracaoController
     * @param ContatoConfiguracaoService $contatoconfiguracaoService
     */
    public function __construct(ContatoConfiguracaoService $contatoconfiguracaoService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->contatoconfiguracaoService = $contatoconfiguracaoService;
        $this->service = 'contatoconfiguracaoService';
        $this->pastaView = 'contato_configuracoes';
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

        $dados = $this->contatoconfiguracaoService->index($request, $ordenacao);
        $dados->setPath('./contato_configuracoes');
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
        $item = $this->contatoconfiguracaoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Exibir o formulário para criar um novo registro.
     *
     * @return Response
     */
    public function create()
    {
        //$options_contato_configuracoes_id = $this->contatoconfiguracaoService->listBox();
        return view('gestor.'.$this->pastaView.'.form');
    }

    /**
     * Armazenar o novo registro.
     *
     * @param ContatoConfiguracaoRequest $contatoconfiguracaoRequest
     * @return Response
     */
    public function store(ContatoConfiguracaoRequest $contatoconfiguracaoRequest)
    {
        $this->contatoconfiguracaoService->store($contatoconfiguracaoRequest);
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
        //$options_contato_configuracoes_id = $this->contatoconfiguracaoService->listBox();
        $item = $this->contatoconfiguracaoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Atualizar um registro específico.
     *
     * @param ContatoConfiguracaoRequest $contatoconfiguracaoRequest
     * @param int $id
     * @return Response
     */
    public function update(
        ContatoConfiguracaoRequest $contatoconfiguracaoRequest,
        $id)
    {
        $this->contatoconfiguracaoService->update($contatoconfiguracaoRequest, $id);
        return redirect()->route('gestor.'.$this->pastaView.'.index')
            ->with('mensagem', 'Atualizado com sucesso')
            ->with('tipo_mensagem', 'success');
    }
}
