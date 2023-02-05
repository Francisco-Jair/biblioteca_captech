<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 01-11-2015
 * Time: 00:05:20
 */

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Criar uma nova nova instância de MenuController
     *
     * @param \App\Services\ProcessoService
     */
    public function __construct()
    {
    }

    public function dashboard()
    {

        return view('gestor.dashboard.index');
    }

} 