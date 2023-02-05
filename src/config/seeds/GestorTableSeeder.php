<?php

use App\Models\Gestor;
use Illuminate\Database\Seeder;

class GestorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('gestores')->truncate();

        Gestor::create([
            'id' => '1',
            'uid' => '7ff6338a5b56041bd2f68e2c46bdaa971d2d7ff8b1b9f96fc512fa966932e0af5109b069c31c539cde9da8e455744df21b7c04d6f3c376c7f7294755d9a19002',
            'nome' => 'Rupert Lustosa',
            'email' => 'rupertlustosa@gmail.com',
            'password' => '$2y$10$1xzU96wZWxa6kfi8O27sKeHxuBhLqBPplkc/.9i/nipvDhbji./WO',
            'isAdmin' => 'N'
        ]);

        Gestor::create([
            'id' => '2',
            'uid' => '$2y$10$v0m/YEDNXLAJOXRdnTIA2eUmrfp/9q1xB8xdmhnkSyGFrP9NPW.my',
            'nome' => 'Rsirius',
            'email' => 'rsirius@gmail.com',
            'password' => '$2y$10$v0m/YEDNXLAJOXRdnTIA2eUmrfp/9q1xB8xdmhnkSyGFrP9NPW.my',
            'isAdmin' => 'S'
        ]);
    }
}
