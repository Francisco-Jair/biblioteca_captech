<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 03:28:50
 */

namespace App\Repositories;

use App\Models\Contato;

class ContatoRepository
{

    /**
     * Criar uma nova instância de ContatoRepository.
     * @param Contato $contato
     */
    public function __construct(Contato $contato)
    {
        $this->model = $contato;
    }


    /**
     * Recuperar uma Coleção paginada de Contato
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

        if (isset($parametros['termo'])) {
            $termo = strtolower(trim($parametros['termo']));

            $query = $query->where(function ($q2) use ($termo) {
                $q2->whereRaw('
                    (LOWER(nome) LIKE ? or LOWER(email) LIKE ? or LOWER(mensagem) LIKE ?)',
                    ["%{$termo}%", "%{$termo}%", "%{$termo}%"]
                );
            });
        }

        return $query->paginate($registros);
    }

    /**
     * Recuperar um ítem do Model Contato
     * @param  int $id
     * @return Contato $contato
     */
    public function find($id)
    {
        return $item = $this->model->findOrFail($id);
    }

    /**
     * Criar Contato
     * @param array $dados
     * @return Contato $contato
     * @throws \Exception
     */
    public function store(array $dados)
    {
        $contato = new $this->model;
        return $this->saveContato($contato, $dados);
    }

    /**
     * Atualizar Contato.
     *
     * @param array $dados
     * @param  int $id
     * @return Contato $contato
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $contato = $this->model->findOrFail($id);
        return $this->saveContato($contato, $dados);
    }

    /**
     * Salvar Contato.
     * @param Contato $contato
     * @param array $dados
     * @return Contato
     * @throws \Exception
     */
    private function saveContato(Contato $contato, array $dados)
    {
        \DB::beginTransaction();
        try {
            if (isset($dados['assunto_id']))
                $contato->assunto_id = trim($dados['assunto_id']);
            if (isset($dados['nome']))
                $contato->nome = trim($dados['nome']);
            if (isset($dados['email']))
                $contato->email = trim($dados['email']);
            if (isset($dados['telefone']))
                $contato->telefone = trim($dados['telefone']);
            if (isset($dados['mensagem']))
                $contato->mensagem = trim($dados['mensagem']);
            if (!isset($dados['id'])) {
                $contato->ip = $_SERVER['REMOTE_ADDR'];
                $contato->novo = 'S';
            }

            $contato->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return $contato;
    }


    /**
     * Verifica se o model tem dependência de algum outro model
     * @param Contato $contato
     * @return bool
     */

    public function contatoTemRegistros(Contato $contato)
    {
        return $contato->where('id', '=', 0);
    }

    /**
     * Excluir um registro.
     * @param Contato $contato
     * @return bool
     * @throws \Exception
     */
    public function destroy(Contato $contato)
    {
        \DB::beginTransaction();
        try {
            $contato->delete();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e);
        }
        \DB::commit();

        return true;
    }

    /**
     * Recuperar um array de Contato para o listBox
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function listBox()
    {
        return $this->model->select('id', 'id')->orderBy('id', 'asc')->get();
    }

    public function marcaComoLido($id)
    {
        $this->model->where('id', $id)
            ->where('novo', 'S')
            ->update(['novo' => 'N']);
    }
}