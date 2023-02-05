<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:07:00
 */

namespace App\Repositories;

use App\Models\LogAtividade;

class LogAtividadeRepository
{

    /**
     * Criar uma nova instância de LogAtividadeRepository.
     * @param LogAtividade $logatividade
     */
    public function __construct(LogAtividade $logatividade)
    {
        $this->model = $logatividade;
    }


    /**
     * Recuperar uma Coleção paginada de LogAtividade
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

        if (isset($parametros['logatividade'])) {
            $logatividade = strtolower($parametros['logatividade']);

            $query = $query->where(function ($q2) use ($logatividade) {
                $q2->whereRaw('LOWER(logatividade) LIKE ?', array("%{$logatividade}%"));
            });
        }

        if (isset($parametros['termo'])) {
            $termo = strtolower(trim($parametros['termo']));

            $query = $query->where(function ($q2) use ($termo) {
                $q2->whereRaw('
                    (LOWER(operacao) LIKE ? or LOWER(modulo) LIKE ? or LOWER(pagina) LIKE ?)',
                    ["%{$termo}%", "%{$termo}%", "%{$termo}%"]
                );
            });
        }

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model LogAtividade
     * @param  int $id
     * @return LogAtividade $logatividade
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar LogAtividade
     * @param array $dados
     * @return LogAtividade $logatividade
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $logatividade = new $this->model;
        return $this->saveLogAtividade($logatividade, $dados);
    }

    /**
     * Atualizar LogAtividade.
     *
     * @param array $dados
     * @param  int $id
     * @return LogAtividade $logatividade
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $logatividade = $this->model->findOrFail($id);
        return $this->saveLogAtividade($logatividade, $dados);
    }

    /**
     * Salvar LogAtividade.
     * @param LogAtividade $logatividade
     * @param array $dados
     * @return LogAtividade
     * @throws \Exception
     */
    private function saveLogAtividade(LogAtividade $logatividade, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['gestor_id']))
                $logatividade->gestor_id = trim($dados['gestor_id']);
            if (isset($dados['operacao']))
                $logatividade->operacao = trim($dados['operacao']);
            if (isset($dados['modulo']))
                $logatividade->modulo = trim($dados['modulo']);
            if (isset($dados['pagina']))
                $logatividade->pagina = trim($dados['pagina']);
            if (isset($dados['dados']))
                $logatividade->dados = trim($dados['dados']);

            $logatividade->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $logatividade;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param LogAtividade $logatividade
     * @return bool
     */

    public function logatividadeTemRegistros(LogAtividade $logatividade)
    {
        return $logatividade->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param LogAtividade $logatividade
     * @return bool
     * @throws \Exception
     */
    public function destroy(LogAtividade $logatividade)
    {
        \DB::beginTransaction();
        try {
            $logatividade->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de LogAtividade para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'id')->orderBy('id', 'asc')->get();
    }

}