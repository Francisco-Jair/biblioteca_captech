<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:01:10
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ConfiguracaoRequest;
use App\Repositories\ConfiguracaoRepository;

class ConfiguracaoService
{
    /**
     * Instância de ConfiguracaoRepository
     * @var ConfiguracaoRepository
     */
    protected $configuracaoRepository;

    /**
     * Criar uma nova nova instância de ConfiguracaoService
     * @param ConfiguracaoRepository $configuracaoRepository
     */
    public function __construct(ConfiguracaoRepository $configuracaoRepository)
    {
        $this->configuracaoRepository = $configuracaoRepository;
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
        if ($request->query('sort'))
            $parametros['sort'] = $request->get('sort');

        if ($request->query('configuracao'))
            $parametros['configuracao'] = $request->get('configuracao');
        return $this->configuracaoRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\Configuracao
     */
    public function find($id)
    {
        return $this->configuracaoRepository->find($id);
    }

    /**
     * Armazenar o novo registro no repositório de dados.
     * @param ConfiguracaoRequest $configuracaoRequest
     * @return \App\Models\Configuracao
     */
    public function store(ConfiguracaoRequest $configuracaoRequest)
    {
        $dados = $configuracaoRequest->all();
        return $this->configuracaoRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param ConfiguracaoRequest $configuracaoRequest
     * @param int $id
     * @return \App\Models\Configuracao
     */
    public function update(
        ConfiguracaoRequest $configuracaoRequest,
        $id)
    {
        $dados = $configuracaoRequest->all();
        return $this->configuracaoRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $configuracao = $this->configuracaoRepository->find($id);

        $configuracaoTemRegistros = $this->configuracaoRepository->configuracaoTemRegistros($configuracao);

        if ($configuracaoTemRegistros->count()) {
            $verificacao['configuracao'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $configuracaoTemRegistros];
        }

        return ['item' => $configuracao, 'verificacao' => $verificacao];
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
            if ($this->configuracaoRepository->destroy($item))
                $mensagem = 'Registro "' . $item->chave . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->chave . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de Configuracao para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->configuracaoRepository->listBox() as $item) {
            $list[$item->id] = $item->id;
        }

        return $list;
    }

    /**
     * Retornar todas as configurações
     * @return array
     */
    public function todasAsConfiguracoes()
    {
        $tempoDeCache = config('configuracoes.tempoCache.configuracoesGerais');
        $todasAsConfiguracoes = Cache::remember('todasAsConfiguracoes', $tempoDeCache, function () {
            return $this->configuracaoRepository->todasAsConfiguracoes();
        });
        $configuracoes = [];
        foreach ($todasAsConfiguracoes as $configuracao) {
            $configuracoes[$configuracao->titulo] = $configuracao->valor;
        }
        return $configuracoes;
    }
}