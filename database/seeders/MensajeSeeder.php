<?php

namespace Database\Seeders;

use App\Models\Mensaje;
use Illuminate\Database\Seeder;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mensaje::create([
            'color' => '#D7C954',
            'mensaje' => 'Al que madruga, Dios lo ayuda',
        ]);

        Mensaje::create([
            'color' => '#54D78C',
            'mensaje' => 'El conocimiento es poder.',
        ]);

        Mensaje::create([
            'color' => '#54A2D7',
            'mensaje' => 'La educación es el arma más poderosa.',
        ]);
    }
}
