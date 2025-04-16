<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new DateTime('1976-01-01');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
        ]);
        $admin->assignRole('Admin');

        $admin->perfil()->create([
            'nombre' => 'Gino',
            'apellido' => 'Salazar',
            'dni' => '12365478',
            'fecha_nac' => $date,
            'edad' => '45',
            'sexo' => 'm',
            'direccion' => 'direccion',
            'distrito' => 'V.E.S',
        ]);

        // Crear usuario administrador subdirector
        $admin2 = User::create([
            'name' => 'subdirector',
            'email' => 'subdirector@gmail.com',
            'password' => bcrypt('12345'),
        ]);
        $admin2->assignRole('Admin');

        $admin2->perfil()->create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '87654321',
            'fecha_nac' => new DateTime('1980-05-15'),
            'edad' => '41',
            'sexo' => 'm',
            'direccion' => 'otra direccion',
            'distrito' => 'Miraflores',
        ]);
    }
}
