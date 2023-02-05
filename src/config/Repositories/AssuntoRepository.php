<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:39:09
 */

namespace App\Repositories;

use App\Models\Assunto;

class AssuntoRepository
{

    /**
     * Criar uma nova instância de AssuntoRepository.
     * @param Assunto $assunto
     */
    public function __construct(Assunto $assunto)
    {
        $this->model = $assunto;
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

        if (isset($parametros['assunto'])) {
            $assunto = strtolower($parametros['assunto']);

            $query = $query->where(function ($q2) use ($assunto) {
                $q2->whereRaw('LOWER(assunto) LIKE ?', array("%{$assunto}%"));
            });
        }

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model Assunto
     * @param  int $id
     * @return Assunto $assunto
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar Assunto
     * @param array $dados
     * @return Assunto $assunto
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $assunto = new $this->model;
        return $this->saveAssunto($assunto, $dados);
    }

    /**
     * Atualizar Assunto.
     *
     * @param array $dados
     * @param  int $id
     * @return Assunto $assunto
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $assunto = $this->model->findOrFail($id);
        return $this->saveAssunto($assunto, $dados);
    }

    /**
     * Salvar Assunto.
     * @param Assunto $assunto
     * @param array $dados
     * @return Assunto
     * @throws \Exception
     */
    private function saveAssunto(Assunto $assunto, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['assunto']))
                $assunto->assunto = trim($dados['assunto']);
            if (isset($dados['emails']))
                $assunto->emails = trim($dados['emails']);

            $assunto->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $assunto;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param Assunto $assunto
     * @return bool
     */

    public function assuntoTemRegistros(Assunto $assunto)
    {
        return $assunto->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param Assunto $assunto
     * @return bool
     * @throws \Exception
     */
    public function destroy(Assunto $assunto)
    {
        \DB::beginTransaction();
        try {
            $assunto->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de Assunto para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'assunto')->orderBy('assunto', 'asc')->get();
    }
}