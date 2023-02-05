<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:13:42
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ContatoConfiguracaoRequest;
use App\Repositories\ContatoConfiguracaoRepository;

class ContatoConfiguracaoService
{
    /**
     * Instância de ContatoConfiguracaoRepository
     * @var ContatoConfiguracaoRepository
     */
    protected $contatoconfiguracaoRepository;

    /**
     * Criar uma nova nova instância de ContatoConfiguracaoService
     * @param ContatoConfiguracaoRepository $contatoconfiguracaoRepository
     */
    public function __construct(ContatoConfiguracaoRepository $contatoconfiguracaoRepository)
    {
        $this->contatoconfiguracaoRepository = $contatoconfiguracaoRepository;
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

        if ($request->query('contatoconfiguracao'))
            $parametros['contatoconfiguracao'] = $request->get('contatoconfiguracao');
        return $this->contatoconfiguracaoRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\ContatoConfiguracao
     */
    public function find($id)
    {
        return $this->contatoconfiguracaoRepository->find($id);
    }

    /**
     * Armazenar o novo registro no repositório de dados.
     * @param ContatoConfiguracaoRequest $contatoconfiguracaoRequest
     * @return \App\Models\ContatoConfiguracao
     */
    public function store(ContatoConfiguracaoRequest $contatoconfiguracaoRequest)
    {
        $dados = $contatoconfiguracaoRequest->all();

        return $this->contatoconfiguracaoRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param ContatoConfiguracaoRequest $contatoconfiguracaoRequest
     * @param int $id
     * @return \App\Models\ContatoConfiguracao
     */
    public function update(
        ContatoConfiguracaoRequest $contatoconfiguracaoRequest,
        $id)
    {
        $dados = $contatoconfiguracaoRequest->all();

        return $this->contatoconfiguracaoRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $contatoconfiguracao = $this->contatoconfiguracaoRepository->find($id);

        $contatoconfiguracaoTemRegistros = $this->contatoconfiguracaoRepository->contatoconfiguracaoTemRegistros($contatoconfiguracao);

        if ($contatoconfiguracaoTemRegistros->count()) {
            $verificacao['contatoconfiguracao'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $contatoconfiguracaoTemRegistros];
        }

        return ['item' => $contatoconfiguracao, 'verificacao' => $verificacao];
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
            if ($this->contatoconfiguracaoRepository->destroy($item))
                $mensagem = 'Registro "' . $item->chave . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->chave . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de ContatoConfiguracao para o listBox
     * @return array
     */
    public function listBox()
    {
        $list[''] = '';

        foreach ($this->contatoconfiguracaoRepository->listBox() as $item) {
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
        $tempoDeCache = config('configuracoes.tempoCache.configuracoesDeContato');
        $todasAsConfiguracoes = Cache::remember('todasAsConfiguracoesDoContato', $tempoDeCache, function () {
            return $this->contatoconfiguracaoRepository->todasAsConfiguracoes();
        });
        $configuracoes = [];
        foreach ($todasAsConfiguracoes as $configuracao) {
            $descricao = str_replace('<br />', ', ', $configuracao->descricao);
            $descricao = str_replace('<br/>', ', ', $descricao);
            $descricao = str_replace('<br>', ', ', $descricao);
            $configuracoes[$configuracao->titulo] = ['descricaoOriginal' => $configuracao->descricao, 'descricao' => $descricao];
        }
        return $configuracoes;
    }
}