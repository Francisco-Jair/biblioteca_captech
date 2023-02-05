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

class BaseComposerGestor
{

    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $valorLeftPanel = \Request::cookie('left-panel');

        $view->with('valorLeftPanel', $valorLeftPanel);
    }
}