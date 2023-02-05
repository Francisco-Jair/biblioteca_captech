<?php

use App\Models\Configuracao;
use Illuminate\Database\Seeder;

class ConfiguracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('Configuracaoes')->truncate();

        Configuracao::create([
            'titulo' => 'Título do site',
            'chave' => 'ceo-site-title',
            'valor' => 'Título'
        ]);

        Configuracao::create([
            'titulo' => 'Descrição do site',
            'chave' => 'ceo-site-description',
            'valor' => 'Descrição'
        ]);

        Configuracao::create([
            'titulo' => 'Keywords do site',
            'chave' => 'ceo-site-keywords',
            'valor' => 'Palavras Chaves'
        ]);
        /*Configuracao::create([
            'titulo' => '',
            'chave' => '',
            'valor' => ''
        ]);*/
    }
}
