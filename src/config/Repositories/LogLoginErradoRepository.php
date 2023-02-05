<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:00:05
 */

namespace App\Repositories;

use App\Models\LogLoginErrado;

class LogLoginErradoRepository
{

    /**
     * Criar uma nova instância de LogLoginErradoRepository.
     * @param LogLoginErrado $logloginerrado
     */
    public function __construct(LogLoginErrado $logloginerrado)
    {
        $this->model = $logloginerrado;
    }


    /**
     * Recuperar uma Coleção paginada de LogLoginErrado
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

        if (isset($parametros['logloginerrado'])) {
            $logloginerrado = strtolower($parametros['logloginerrado']);

            $query = $query->where(function ($q2) use ($logloginerrado) {
                $q2->whereRaw('LOWER(logloginerrado) LIKE ?', array("%{$logloginerrado}%"));
            });
        }

        if (isset($parametros['termo'])) {
            $termo = strtolower(trim($parametros['termo']));

            $query = $query->where(function ($q2) use ($termo) {
                $q2->whereRaw('
                    (LOWER(login) LIKE ? or LOWER(senha) LIKE ?)',
                    ["%{$termo}%", "%{$termo}%"]
                );
            });
        }

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model LogLoginErrado
     * @param  int $id
     * @return LogLoginErrado $logloginerrado
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar LogLoginErrado
     * @param array $dados
     * @return LogLoginErrado $logloginerrado
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $logloginerrado = new $this->model;
        return $this->saveLogLoginErrado($logloginerrado, $dados);
    }

    /**
     * Atualizar LogLoginErrado.
     *
     * @param array $dados
     * @param  int $id
     * @return LogLoginErrado $logloginerrado
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $logloginerrado = $this->model->findOrFail($id);
        return $this->saveLogLoginErrado($logloginerrado, $dados);
    }

    /**
     * Salvar LogLoginErrado.
     * @param LogLoginErrado $logloginerrado
     * @param array $dados
     * @return LogLoginErrado
     * @throws \Exception
     */
    private function saveLogLoginErrado(LogLoginErrado $logloginerrado, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['ip']))
                $logloginerrado->ip = trim($dados['ip']);
            if (isset($dados['login']))
                $logloginerrado->login = trim($dados['login']);
            if (isset($dados['senha']))
                $logloginerrado->senha = trim($dados['senha']);

            $logloginerrado->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $logloginerrado;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param LogLoginErrado $logloginerrado
     * @return bool
     */

    public function logloginerradoTemRegistros(LogLoginErrado $logloginerrado)
    {
        return $logloginerrado->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param LogLoginErrado $logloginerrado
     * @return bool
     * @throws \Exception
     */
    public function destroy(LogLoginErrado $logloginerrado)
    {
        \DB::beginTransaction();
        try {
            $logloginerrado->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de LogLoginErrado para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'id')->orderBy('id', 'asc')->get();
    }

}