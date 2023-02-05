<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service = '{$this->service}';

    /**
     * Pasta base da view do módulo
     *
     * @var pastaView
     */
    protected $pastaView;

    /**
     * Exibir um formulário de confirmação de exclusão de um registro específico.
     *
     * @param  int $id
     * @return Response
     */
    public function confirmDestroy($id)
    {
        $this->log(__METHOD__);

        $response = $this->{$this->service}->confirmDestroy($id);
        $item = $response['item'];
        $verificacao = $response['verificacao'];
        return view('gestor.' . $this->pastaView . '.confirm-destroy', compact('item', 'verificacao'));
    }

    /**
     * Excluir um registro.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->log(__METHOD__);

        $mensagem = $this->{$this->service}->destroy($id);
        return \Redirect::route('gestor.' . $this->pastaView . '.index')
            ->with('mensagem', $mensagem)
            ->with('tipo_mensagem', 'danger');
    }

    /**
     * Exibir um formulário de edição de um registro específico.
     *
     * @param  int $id
     * @param null $ordemImagem
     * @return Response
     */
    public function imageCrop($id, $ordemImagem = null)
    {
        $this->log(__METHOD__);

        $item = $this->{$this->service}->find($id);
        $item->imagem = $item->{'imagem' . $ordemImagem};
        return view('gestor.' . $this->pastaView . '.image-crop', compact('item', 'ordemImagem'));
    }

    /**
     * Atualizar um registro específico.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function updateImageCrop(
        Request $request,
        $id)
    {
        $this->log(__METHOD__);

        $cortou = $this->{$this->service}->updateImageCrop($request, '' . $this->pastaView . '');
        if ($cortou)
            return \Redirect::route('gestor.' . $this->pastaView . '.index')
                ->with('mensagem', 'Imagem atualizada com sucesso')
                ->with('tipo_mensagem', 'success');
        else return \Redirect::route('gestor.' . $this->pastaView . '.imageCrop')
            ->with('mensagem', 'Erro ao atualizar imagem')
            ->with('tipo_mensagem', 'danger');
    }


    public function imageDestroy($id, $ordemImagem = null)
    {
        $this->log(__METHOD__);

        $retorno = $this->{$this->service}->imageDestroy($id, $ordemImagem);
        if ($retorno)
            return \Redirect::route('gestor.' . $this->pastaView . '.index')
                ->with('mensagem', 'Imagem removida com sucesso')
                ->with('tipo_mensagem', 'success');
        else return \Redirect::route('gestor.' . $this->pastaView . '.index')
            ->with('mensagem', 'Erro ao remover imagem')
            ->with('tipo_mensagem', 'danger');
    }

    public function operacaoNaoPermitida()
    {
        $this->log(__METHOD__);

        return redirect()->route('gestor.' . $this->pastaView . '.index')
            ->with('mensagem', 'Operação não permitida')
            ->with('tipo_mensagem', 'danger');
    }
}