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
            "color" => "#D7C954",
            "mensaje" => "Al que madruga, Dios lo ayuda"]);
    }
}
