<?php

use App\Models\ContatoConfiguracao;
use Illuminate\Database\Seeder;

class ContatoContatoConfiguracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('contato_configuracoes')->truncate();

        ContatoConfiguracao::create([
            'titulo' => 'Latitude no Mapa',
            'chave' => 'mapa-latitude',
            'valor' => '-5.092395'
        ]);

        ContatoConfiguracao::create([
            'titulo' => 'Longitude no Mapa',
            'chave' => 'mapa-longitude',
            'valor' => '-42.801438'
        ]);

        /*ContatoConfiguracao::create([
            'titulo' => '',
            'chave' => '',
            'valor' => ''
        ]);*/
    }
}
