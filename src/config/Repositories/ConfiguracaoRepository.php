<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:01:09
 */

namespace App\Repositories;

use App\Models\Configuracao;

class ConfiguracaoRepository
{

    /**
     * Criar uma nova instância de ConfiguracaoRepository.
     * @param Configuracao $configuracao
     */
    public function __construct(Configuracao $configuracao)
    {
        $this->model = $configuracao;
    }


    /**
     * Recuperar uma Coleção paginada de ContatoConfiguracao
     * @param int $registros
     * @param array $parametros
     * @param array $ordenacao
     * @return Illuminate\Database\Eloquent\Collection
     */

    public function index($registros, $parametros = [], $ordenacao = [])
    {
        if (!isset($ordenacao['sort']))
            $ordenacao['sort'] = 'id';

        if (!isset($ordenacao['order']))
            $ordenacao['order'] = 'DESC';

        $query = $this->model->orderBy($ordenacao['sort'], $ordenacao['order']);

        if (isset($parametros['id'])) {
            $id = (int)$parametros['id'];

            if ($id > 0) {
                $query = $query->where(function ($q2) use ($id) {
                    $q2->whereRaw('id = ?', array($id));
                });
            }

        }

        if (isset($parametros['configuracao'])) {
            $configuracao = strtolower($parametros['configuracao']);

            $query = $query->where(function ($q2) use ($configuracao) {
                $q2->whereRaw('LOWER(configuracao) LIKE ?', array("%{$configuracao}%"));
            });
        }

        /*if (isset($parametros['termo'])) {
            $termo = strtolower(trim($parametros['termo']));

            $query = $query->where(function ($q2) use ($termo) {
                $q2->whereRaw('
                    (LOWER(xxx) LIKE ? or LOWER(yyy) LIKE ? or LOWER(zzz) LIKE ?)',
                    ["%{$termo}%", "%{$termo}%", "%{$termo}%"]
                );
            });
        }*/

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model Configuracao
     * @param  int $id
     * @return Configuracao $configuracao
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar Configuracao
     * @param array $dados
     * @return Configuracao $configuracao
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $configuracao = new $this->model;
        return $this->saveConfiguracao($configuracao, $dados);
    }

    /**
     * Atualizar Configuracao.
     *
     * @param array $dados
     * @param  int $id
     * @return Configuracao $configuracao
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $configuracao = $this->model->findOrFail($id);
        return $this->saveConfiguracao($configuracao, $dados);
    }

    /**
     * Salvar Configuracao.
     * @param Configuracao $configuracao
     * @param array $dados
     * @return Configuracao
     * @throws \Exception
     */
    private function saveConfiguracao(Configuracao $configuracao, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['titulo']))
                $configuracao->titulo = trim($dados['titulo']);
            if (isset($dados['chave']))
                $configuracao->chave = trim($dados['chave']);
            if (isset($dados['valor']))
                $configuracao->valor = trim($dados['valor']);

            $configuracao->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $configuracao;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param Configuracao $configuracao
     * @return bool
     */

    public function configuracaoTemRegistros(Configuracao $configuracao)
    {
        return $configuracao->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param Configuracao $configuracao
     * @return bool
     * @throws \Exception
     */
    public function destroy(Configuracao $configuracao)
    {
        \DB::beginTransaction();
        try {
            $configuracao->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de Configuracao para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'titulo')->orderBy('titulo', 'asc')->get();
    }
}