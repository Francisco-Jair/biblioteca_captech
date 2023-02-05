<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:01:09
 */

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Traits\LogAtividades;
use App\Http\Requests\ConfiguracaoRequest;
use App\Services\ConfiguracaoService;

class ConfiguracaoController extends BaseController
{
    use LogAtividades;
    /**
     * Instância de ConfiguracaoService
     *
     * @var ConfiguracaoService
     */
    protected $configuracaoService;

    /**
     * Criar uma nova nova instância de ConfiguracaoController
     * @param ConfiguracaoService $configuracaoService
     */
    public function __construct(ConfiguracaoService $configuracaoService)
    {
        $this->log('acessou',__CLASS__,'');
        $this->configuracaoService = $configuracaoService;
        $this->service = 'configuracaoService';
        $this->pastaView = 'configuracoes';
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

        $dados = $this->configuracaoService->index($request, $ordenacao);
        $dados->setPath('./configuracoes');
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
        $item = $this->configuracaoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Exibir o formulário para criar um novo registro.
     *
     * @return Response
     */
    public function create()
    {
        //$options_configuracoes_id = $this->configuracaoService->listBox();
        return view('gestor.'.$this->pastaView.'.form');
    }

    /**
     * Armazenar o novo registro.
     *
     * @param ConfiguracaoRequest $configuracaoRequest
     * @return Response
     */
    public function store(ConfiguracaoRequest $configuracaoRequest)
    {
        $this->configuracaoService->store($configuracaoRequest);
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
        //$options_configuracoes_id = $this->configuracaoService->listBox();
        $item = $this->configuracaoService->find($id);
        return view('gestor.'.$this->pastaView.'.form', compact('item'));
    }

    /**
     * Atualizar um registro específico.
     *
     * @param ConfiguracaoRequest $configuracaoRequest
     * @param int $id
     * @return Response
     */
    public function update(
        ConfiguracaoRequest $configuracaoRequest,
        $id)
    {
        $this->configuracaoService->update($configuracaoRequest, $id);
        return redirect()->route('gestor.'.$this->pastaView.'.index')
            ->with('mensagem', 'Atualizado com sucesso')
            ->with('tipo_mensagem', 'success');
    }
}
