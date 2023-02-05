<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 16-11-2015
 * Time: 02:39:10
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\AssuntoRequest;
use App\Repositories\AssuntoRepository;

class AssuntoService
{
    /**
     * Instância de AssuntoRepository
     * @var AssuntoRepository
     */
    protected $assuntoRepository;

    /**
     * Criar uma nova nova instância de AssuntoService
     * @param AssuntoRepository $assuntoRepository
     */
    public function __construct(AssuntoRepository $assuntoRepository)
    {
        $this->assuntoRepository = $assuntoRepository;
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

        if ($request->query('assunto'))
            $parametros['assunto'] = $request->get('assunto');
        return $this->assuntoRepository->index(20, $parametros, $ordenacao);
    }

    /**
     * Retornar um registro
     * @param int $id
     * @return \App\Models\Assunto
     */
    public function find($id)
    {
        return $this->assuntoRepository->find($id);
    }

    /**
     * Armazenar o novo registro no repositório de dados.
     * @param AssuntoRequest $assuntoRequest
     * @return \App\Models\Assunto
     */
    public function store(AssuntoRequest $assuntoRequest)
    {
        $dados = $assuntoRequest->all();

        return $this->assuntoRepository->store($dados);
    }

    /**
     * Atualizar o registro especificado.
     * @param AssuntoRequest $assuntoRequest
     * @param int $id
     * @return \App\Models\Assunto
     */
    public function update(
        AssuntoRequest $assuntoRequest,
        $id)
    {
        $dados = $assuntoRequest->all();

        return $this->assuntoRepository->update($dados, $id);
    }

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     * @param int $id
     * @return array
     */
    public function confirmDestroy($id)
    {
        $verificacao = [];
        $assunto = $this->assuntoRepository->find($id);

        $assuntoTemRegistros = $this->assuntoRepository->assuntoTemRegistros($assunto);

        if ($assuntoTemRegistros->count()) {
            $verificacao['assunto'] = ['mensagem' => 'Existem registros relacionados a esse ítem!', 'registros' => $assuntoTemRegistros];
        }

        return ['item' => $assunto, 'verificacao' => $verificacao];
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
            if ($this->assuntoRepository->destroy($item))
                $mensagem = 'Registro "' . $item->assunto . '" removido com sucesso';
            else $mensagem = 'Ocorreu um erro ao remover esse registro "' . $item->assunto . '", tente novamente';
        } else {
            $mensagem = 'Esse ítem possui registros relacionados!';
        }
        return $mensagem;
    }

    /**
     * Recuperar uma coleção de Assunto para o listBox
     * @return array
     */
    public function listBox()
    {
        /*$list[''] = '';

        foreach ($this->assuntoRepository->listBox() as $item) {
            $list[$item->id] = $item->assunto;
        }

        return $list;

        return $this->assuntoRepository->listBox();
        */
        $list[''] = '';
        return Cache::remember('listBoxDeAssuntosDoContato', 60 * 24 * 7, function () {

            //return $this->assuntoRepository->listBox();
            foreach ($this->assuntoRepository->listBox() as $item) {
                $list[$item->id] = $item->assunto;
            }
            return $list;
        });
    }

    /**
     * Recuperar uma coleção de Assunto para o listBox
     * @return array
     */
    public function listBoxGestor()
    {
        return Cache::remember('listBoxDeAssuntosDoContatoDoGestor', 0, function () {
            $list[0] = 'Todos os assuntos';
            //return $this->assuntoRepository->listBox();
            foreach ($this->assuntoRepository->listBox() as $item) {
                $list[$item->id] = $item->assunto;
            }
            return $list;
        });
    }
}