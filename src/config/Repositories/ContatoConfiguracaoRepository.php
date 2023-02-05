<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:13:40
 */

namespace App\Repositories;

use App\Models\ContatoConfiguracao;

class ContatoConfiguracaoRepository
{

    /**
     * Criar uma nova instância de ContatoConfiguracaoRepository.
     * @param ContatoConfiguracao $contatoconfiguracao
     */
    public function __construct(ContatoConfiguracao $contatoconfiguracao)
    {
        $this->model = $contatoconfiguracao;
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

        if (isset($parametros['contatoconfiguracao'])) {
            $contatoconfiguracao = strtolower($parametros['contatoconfiguracao']);

            $query = $query->where(function ($q2) use ($contatoconfiguracao) {
                $q2->whereRaw('LOWER(contatoconfiguracao) LIKE ?', array("%{$contatoconfiguracao}%"));
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
     * Recuperar um ítem do Model ContatoConfiguracao
     * @param  int $id
     * @return ContatoConfiguracao $contatoconfiguracao
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar ContatoConfiguracao
     * @param array $dados
     * @return ContatoConfiguracao $contatoconfiguracao
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $contatoconfiguracao = new $this->model;
        return $this->saveContatoConfiguracao($contatoconfiguracao, $dados);
    }

    /**
     * Atualizar ContatoConfiguracao.
     *
     * @param array $dados
     * @param  int $id
     * @return ContatoConfiguracao $contatoconfiguracao
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $contatoconfiguracao = $this->model->findOrFail($id);
        return $this->saveContatoConfiguracao($contatoconfiguracao, $dados);
    }

    /**
     * Salvar ContatoConfiguracao.
     * @param ContatoConfiguracao $contatoconfiguracao
     * @param array $dados
     * @return ContatoConfiguracao
     * @throws \Exception
     */
    private function saveContatoConfiguracao(ContatoConfiguracao $contatoconfiguracao, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['titulo']))
                $contatoconfiguracao->titulo = trim($dados['titulo']);
            if (isset($dados['chave']))
                $contatoconfiguracao->chave = trim($dados['chave']);
            if (isset($dados['valor']))
                $contatoconfiguracao->valor = trim($dados['valor']);

            $contatoconfiguracao->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $contatoconfiguracao;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param ContatoConfiguracao $contatoconfiguracao
     * @return bool
     */

    public function contatoconfiguracaoTemRegistros(ContatoConfiguracao $contatoconfiguracao)
    {
        //Se esse model não possuir outro model relacionado:
        return $contatoconfiguracao->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param ContatoConfiguracao $contatoconfiguracao
     * @return bool
     * @throws \Exception
     */
    public function destroy(ContatoConfiguracao $contatoconfiguracao)
    {
        \DB::beginTransaction();
        try {
            $contatoconfiguracao->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de ContatoConfiguracao para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'titulo')->orderBy('titulo', 'asc')->get();
    }

    /**
     * Retornar todas as congurações
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function todasAsConfiguracoes()
    {
        return $this->model->all();
    }
}