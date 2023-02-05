<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Http\ViewComposers;

use App\Services\ConfiguracaoService;
use App\Services\ContatoConfiguracaoService;
use Illuminate\Contracts\View\View;

class BaseComposer
{
    /**
     * @var ConfiguracaoService
     */
    private $configuracaoService;
    /**
     * @var ContatoConfiguracaoService
     */
    private $contatoConfiguracaoService;

    /**
     * @param ConfiguracaoService $configuracaoService
     * @param ContatoConfiguracaoService $contatoConfiguracaoService
     */
    public function __construct(ConfiguracaoService $configuracaoService,
                                ContatoConfiguracaoService $contatoConfiguracaoService)
    {
        $this->configuracaoService = $configuracaoService;
        $this->contatoConfiguracaoService = $contatoConfiguracaoService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $configuracao = array_merge($this->configuracaoService->todasAsConfiguracoes(), $this->contatoConfiguracaoService->todasAsConfiguracoes());

        $view->with('configuracao', $configuracao);
    }
}