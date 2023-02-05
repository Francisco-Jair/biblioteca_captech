<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 17-11-2015
 * Time: 03:04:49
 */

namespace App\Repositories;

use App\Models\LogLogin;

class LogLoginRepository
{

    /**
     * Criar uma nova instância de LogLoginRepository.
     * @param LogLogin $loglogin
     */
    public function __construct(LogLogin $loglogin)
    {
        $this->model = $loglogin;
    }


    /**
     * Recuperar uma Coleção paginada de LogLogin
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

        if (isset($parametros['loglogin'])) {
            $loglogin = strtolower($parametros['loglogin']);

            $query = $query->where(function ($q2) use ($loglogin) {
                $q2->whereRaw('LOWER(loglogin) LIKE ?', array("%{$loglogin}%"));
            });
        }

        if (isset($parametros['termo'])) {
            $termo = strtolower(trim($parametros['termo']));

            $query = $query->where(function ($q2) use ($termo) {
                $q2->whereRaw('
                    (LOWER(hash) LIKE ?)',
                    ["%{$termo}%"]
                );
            });
        }

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model LogLogin
     * @param  int $id
     * @return LogLogin $loglogin
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar LogLogin
     * @param array $dados
     * @return LogLogin $loglogin
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $loglogin = new $this->model;
        return $this->saveLogLogin($loglogin, $dados);
    }

    /**
     * Atualizar LogLogin.
     *
     * @param array $dados
     * @param  int $id
     * @return LogLogin $loglogin
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $loglogin = $this->model->findOrFail($id);
        return $this->saveLogLogin($loglogin, $dados);
    }

    /**
     * Salvar LogLogin.
     * @param LogLogin $loglogin
     * @param array $dados
     * @return LogLogin
     * @throws \Exception
     */
    private function saveLogLogin(LogLogin $loglogin, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['gestor_id']))
                $loglogin->gestor_id = trim($dados['gestor_id']);
            if (isset($dados['hash']))
                $loglogin->hash = trim($dados['hash']);
            if (isset($dados['data_entrada']))
                $loglogin->data_entrada = trim($dados['data_entrada']);
            if (isset($dados['data_saida']))
                $loglogin->data_saida = trim($dados['data_saida']);
            if (isset($dados['tempo_conexao']))
                $loglogin->tempo_conexao = trim($dados['tempo_conexao']);
            if (isset($dados['ip']))
                $loglogin->ip = trim($dados['ip']);

            $loglogin->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $loglogin;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param LogLogin $loglogin
     * @return bool
     */

    public function logloginTemRegistros(LogLogin $loglogin)
    {
        return $loglogin->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param LogLogin $loglogin
     * @return bool
     * @throws \Exception
     */
    public function destroy(LogLogin $loglogin)
    {
        \DB::beginTransaction();
        try {
            $loglogin->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de LogLogin para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'id')->orderBy('id', 'asc')->get();
    }
}