<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:48:41
 */

namespace App\Repositories;

use App\Models\Gestor;

class GestorRepository
{

    /**
     * Criar uma nova instância de GestorRepository.
     * @param Gestor $gestor
     */
    public function __construct(Gestor $gestor)
    {
        $this->model = $gestor;
    }


    /**
     * Recuperar uma Coleção paginada de Gestor
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

        $query = $this->model->orderBy($ordenacao['sort'], $ordenacao['order'])
            ->where('isAdmin', 'N');

        if (isset($parametros['id'])) {
            $id = (int)$parametros['id'];

            if ($id > 0) {
                $query = $query->where(function ($q2) use ($id) {
                    $q2->whereRaw('id = ?', array($id));
                });
            }

        }

        if (isset($parametros['gestor'])) {
            $gestor = strtolower($parametros['gestor']);

            $query = $query->where(function ($q2) use ($gestor) {
                $q2->whereRaw('LOWER(gestor) LIKE ?', array("%{$gestor}%"));
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
     * Recuperar um ítem do Model Gestor
     * @param  int $id
     * @return Gestor $gestor
     */
    public function find($id)
    {
        $first = $this->model->where('isAdmin', 'N')->where('uid', $id)->first();

        if ($first) {
            $id = $first->id;
        }
        return $item = $this->model->where('isAdmin', 'N')->findOrFail($id);
    }

    /**
     * Criar Gestor
     * @param array $dados
     * @return Gestor $gestor
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $gestor = new $this->model;
        return $this->saveGestor($gestor, $dados);
    }

    /**
     * Atualizar Gestor.
     *
     * @param array $dados
     * @param  int $id
     * @return Gestor $gestor
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $gestor = $this->model->where('isAdmin', 'N')->findOrFail($id);
        return $this->saveGestor($gestor, $dados);
    }

    /**
     * Salvar Gestor.
     * @param Gestor $gestor
     * @param array $dados
     * @return Gestor
     * @throws \Exception
     */
    private function saveGestor(Gestor $gestor, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['password']) and !empty($dados['password'])) {
                $gestor->uid = hash('whirlpool', bcrypt($dados['nome'] . rand(1, 100) . $dados['email'] . rand(1, 100) . $dados['password']));
                $gestor->password = trim(bcrypt($dados['password']));
            } else $gestor->uid = hash('whirlpool', bcrypt($dados['nome'] . rand(1, 100) . $dados['email'] . rand(1, 100) . $dados['password']));
            if (isset($dados['nome']))
                $gestor->nome = trim($dados['nome']);
            if (isset($dados['email']))
                $gestor->email = trim($dados['email']);
            //if (isset($dados['isAdmin']))
            $gestor->isAdmin = 'N';//trim($dados['isAdmin']);

            $gestor->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $gestor;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param Gestor $gestor
     * @return bool
     */

    public function gestorTemRegistros(Gestor $gestor)
    {
        // Esse return é apenas para bloquear a exclusão.
        return $gestor->get();

        //Se esse model possuir outro model relacionado:
        //return $gestor->metodoHasMany();

        //Se esse model não possuir outro model relacionado:
        return $gestor->where('id', 0);
    }

    /**
     * Excluir um registro.
     * @param Gestor $gestor
     * @return bool
     * @throws \Exception
     */
    public function destroy(Gestor $gestor)
    {
        \DB::beginTransaction();
        try {
            $gestor->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de Gestor para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'id')
            ->where('isAdmin', 'N')
            ->orderBy('id', 'asc')->get();
    }
}