<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 15-09-2015
 * Time: 00:02:53
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Services\AssuntoService;
use App\Services\ContatoConfiguracaoService;
use App\Services\ContatoService;
use Illuminate\Http\Request;
use Validator;

class SiteController extends Controller
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            \App::setLocale($locale);
        }
    }

    /**
     * @param Request $request
     * @param $locale
     * @return mixed
     */
    public function locale(Request $request, $locale)
    {
        if ($locale != 'en')
            $locale = 'pt-BR';

        $request->session()->put('locale', $locale);
        return \Redirect::route('site.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pagina = 'home';
        $keywords = '';

        $dados = [];
        return view('site.index', compact('dados', 'pagina', 'keywords'));
    }

    /**
     * @param ContatoConfiguracaoService $contatoConfiguracaoService
     * @param FilialService $filialService
     * @param AssuntoService $assuntoService
     * @return \Illuminate\View\View
     */
    public function contato(ContatoConfiguracaoService $contatoConfiguracaoService, FilialService $filialService, AssuntoService $assuntoService)
    {
        $pagina = 'contato';
        $keywords = '';

        $configuracoesDeContato = $contatoConfiguracaoService->todasAsConfiguracoes();
        $listaDeAssuntos = $assuntoService->listBox();
        $listaDeAssuntos = array_merge(['' => 'Escolha o tipo de contato'], $listaDeAssuntos);

        return view('site.contato', compact('filiais', 'pagina', 'keywords', 'configuracoesDeContato', 'listaDeAssuntos'));
    }

    /**
     * Armazenar o contato.
     *
     * @param ContatoRequest $contatoRequest
     * @param ContatoService $contatoService
     * @return Response
     */
    public function contatoStore(ContatoRequest $contatoRequest, ContatoService $contatoService)
    {
        $contatoService->store($contatoRequest);
        return \Redirect::route('site.contato')->with('mensagem', 'Mensagem enviada com sucesso');
    }
}