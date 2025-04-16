<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Perfil;
use App\Models\User;
use App\Models\Docente;
use App\Models\Level;
use DateTime;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //COSAS DE EMMNANUEL

            $admin = User::create([
                "name" => "Gino",
                "email" => "ginosalazar@gmail.com",
                "password" => bcrypt("12345")
            ])->assignRole('Admin');

            $date = new DateTime("1976-01-01");

            $admin->perfil()->create(
                [
                    "nombre" => "Gino",
                    "apellido" => "Salazar",
                    "DNI" => "12365478",
                    "fecha_nac" => $date,
                    "edad" => "45",
                    "sexo" => "m",
                    "direccion" => "direccion",
                    "distrito" => "V.E.S"
                ]
                );

            $admin->assignRole('Admin');


            $admin2 = User::create([
                "name" => "subdirector",
                "email" => "subdirector@gmail.com",
                "password" => bcrypt("12345")
            ])->assignRole('Admin');

            $admin2->perfil()->create(
                [
                    "nombre" => "subdirector",
                    "apellido" => "sub",
                    "DNI" => "32165487",
                    "fecha_nac" => $date,
                    "edad" => "54",
                    "sexo" => "m",
                    "direccion" => "direccion",
                    "distrito" => "V.M.T"
                ]
                );
                $admin2->assignRole('Admin');
    // CREACION DE LOS DEMAS USUARIOS

    //CREACION DE DOCENTES ****************************************************************************

    //    $docentes = User::factory(5)->create();
    //     //Selecciona a todos los usuarios asignando a la variable todos

    //     foreach ($docentes as $d) {

    //         Perfil::factory()->create([

    //             //Iguala el name de los usuarios a nombre de los perfiles
    //             "nombre" => $d->name,
    //             //Iguala el id de los usuarios a user_id de los perfiles
    //             "user_id" => $d->id
    //         ]);

    //         Docente::factory()->create([
    //             "user_id" => $d->id
    //         ]);


    //         $d->assignRole('Docente');

    //             //ASIGNAMOS MATERIAS RANDOM AL DOCENTE
    //             //$docID = Docente::find($d->id);
    //             //$docID->materias()->attach([rand(1,10),rand(1,10)]);

    //             //ASIGNAMOS SECCIONES A LOS DOCENTES
    //             //$docID->secciones()->attach([rand(1,12),rand(1,12),rand(1,12),rand(1,12)]);
    //     }


        //CREACION DE ALUMNOS ****************************************************************************

        // $alumnos = User::factory(5)->create();
        // //Selecciona a todos los usuarios asignando a la variable todos

        // foreach ($alumnos as $al) {

        //     Perfil::factory()->create([

        //         //Iguala el name de los usuarios a nombre de los perfiles
        //         "nombre" => $al->name,
        //         //Iguala el id de los usuarios a user_id de los perfiles
        //         "user_id" => $al->id
        //     ]);

        //     //asignacion de secciones y creacion de alumnos

        //     Alumno::factory()->create([
        //         "user_id" => $al->id,
        //         "seccion_id" => random_int(1,12)
        //     ]);
        //     Level::create([
        //         "user_id" => $al->id,
        //         "level" => 1,
        //         "exp" => 0,
        //         "exp_ac" => 0
        //     ]);
        //     $al->assignRole('Alumno');


        // }

    }
}
