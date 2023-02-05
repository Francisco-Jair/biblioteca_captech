<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        view()->composer(
            'site.layouts.base', 'App\Http\ViewComposers\BaseComposer'
        );
        view()->composer(
            'gestor._layouts.base', 'App\Http\ViewComposers\BaseComposerGestor'
        );

        $valorAtual = \Request::cookie('left-panel');
        if(!$valorAtual){
            $newValue = 'collapsed';
            $response = new \Illuminate\Http\Response($newValue);
            $response->withCookie(cookie()->forever('left-panel', $newValue));
        }

        // Using Closure based composers...
        /*view()->composer('dashboard', function ($view) {

        });*/
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}