<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin']);
        $docente = Role::create(['name' => 'Docente']);
        $alumno = Role::create(['name' => 'Alumno']);

        // ********************* PERMISOS ADMIN ***************************** */
        // MENU DEL ADMIN
        Permission::create(['name' => 'admin.index'])->syncRoles([$admin, $docente, $alumno]);

        // CRUD DE GRADOS
        Permission::create(['name' => 'admin.grados.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.grados.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.grados.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.grados.destroy'])->syncRoles([$admin]);

        // GESTION DE SECCIONES
        Permission::create(['name' => 'admin.secciones.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.secciones.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secciones.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secciones.destroy'])->syncRoles([$admin]);

        // CRUD DE USUARIOS
        Permission::create(['name' => 'admin.users.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.show'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.users.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$admin]);

        // CRUD DE ALUMNOS
        Permission::create(['name' => 'admin.alumnos.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.alumnos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.alumnos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.alumnos.destroy'])->syncRoles([$admin]);

        // CRUD DE DOCENTES
        Permission::create(['name' => 'admin.docentes.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.docentes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.docentes.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.docentes.destroy'])->syncRoles([$admin]);

        // CRUD DE MATERIAS
        Permission::create(['name' => 'admin.materias.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.materias.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.materias.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.materias.destroy'])->syncRoles([$admin]);

        // ********************* PERMISOS DOCENTE ***************************** */

        // GESTION DE CARPETAS
        Permission::create(['name' => 'admin.carpetas.index'])->syncRoles([$docente]);
        Permission::create(['name' => 'admin.carpetas.create'])->syncRoles([$docente]);
        Permission::create(['name' => 'admin.carpetas.show'])->syncRoles([$docente]);
        Permission::create(['name' => 'admin.carpetas.edit'])->syncRoles([$docente]);
        Permission::create(['name' => 'admin.carpetas.destroy'])->syncRoles([$docente]);

        // GESTION DE MENSAJES MOTIVADORES
        Permission::create(['name' => 'admin.mensajes.index'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.mensajes.create'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.mensajes.edit'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.mensajes.destroy'])->syncRoles([$admin, $docente]);

        // GESTION DE LOGROS
        Permission::create(['name' => 'admin.logros.index'])->syncRoles([$admin, $docente, $alumno]);
        Permission::create(['name' => 'admin.logros.create'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.logros.edit'])->syncRoles([$admin, $docente]);
        Permission::create(['name' => 'admin.logros.destroy'])->syncRoles([$admin, $docente]);

        // GESTION DE ACTIVIDADES
        Permission::create(['name' => 'admin.actividades.show'])->syncRoles([$docente]); // creacion de actividades para las tareas
        Permission::create(['name' => 'admin.actividades.edit'])->syncRoles([$docente]); // edicion superficial de las actividades de manera individual
        Permission::create(['name' => 'admin.actividades.destroy'])->syncRoles([$docente]); // eliminacion de todas las actividades relacinadas a la tarea

        // GESTION DE ASIGNACION DE LOGROS
        Permission::create(['name' => 'admin.asignaciones.show'])->syncRoles([$docente]); // MOSTRAR TODOS LOS LOGROS DEL ALUMNO ANTES DE LA ASIGNACION
        Permission::create(['name' => 'admin.asignaciones.edit'])->syncRoles([$docente]); // ASIGNACION DE LOGROS AL ALUMNO SELECCIONADO
        Permission::create(['name' => 'admin.asignaciones.destroy'])->syncRoles([$docente]); // ELIMINACION DE UN LOGRO

        // GESTION DE TAREAS
        Permission::create(['name' => 'admin.tareas.show'])->syncRoles([$docente]); // ver los detalles de la tarea y el contenido de las actividades
        Permission::create(['name' => 'admin.tareas.edit'])->syncRoles([$docente]); // edicion de la tarea (datos superficiales)
        Permission::create(['name' => 'admin.tareas.destroy'])->syncRoles([$docente]); // eliminar la tarea con sus actividades completas
        // CREACION DE TAREAS ESCOLARES
        Permission::create(['name' => 'admin.crear_tareas.show'])->syncRoles([$docente]);
        // PERMISO PARA CREAR UNA TAREA (LLEVAR AL MENU DE CREACION) porque es necesario llevar el id de la carpeta para que pueda funcionar

        // GESTION DE REVISIONES DE TAREAS
        Permission::create(['name' => 'admin.revisiones.index'])->syncRoles([$docente]); // ACCESO AL MENU DE BUSQUEDA DE CARPETAS MEDIANTE LA MATERIA Y LA SECCION SELECCIONADA
        Permission::create(['name' => 'admin.revisiones.edit'])->syncRoles([$docente]);  // REVISION DE LAS TAREAS DE LOS ESTUDIANTES POR PARTE DEL PROFESOR
        Permission::create(['name' => 'admin.revisiones.show'])->syncRoles([$docente]);  // MUESTRA LAS TAREAS RELACIONADAS CON EL ID DE LA CARPETA Y ADEMAS QUE ESTEN ACTIVAS (IMPORTANTE)

        // revision de tareas a detalle por parte del docente
        Permission::create(['name' => 'admin.revisar_tareas.edit'])->syncRoles([$docente]);  // VISUALIZACION DE LAS TAREAS para poder revisarlas

        // ********************* PERMISOS ALUMNO ***************************** */

        // PERMISO DE MATERIAS
        Permission::create(['name' => 'alumno.materias.index'])->syncRoles([$alumno]);  // VISUALIZACION DE LAS MATERIAS para poder seleccionarlas
        Permission::create(['name' => 'alumno.materias.show'])->syncRoles([$alumno]);  // VISUALIZACION DE LAS CARPETAS para poder seleccionarlas

        // PERMISO DE CARPETAS
        Permission::create(['name' => 'alumno.carpetas.show'])->syncRoles([$alumno]);  // VISUALIZACION DE LAS TAREAS para poder responderlas

        // PERMISO PARA VER LOGROS PROPIOS DEL ALUMNO
        Permission::create(['name' => 'alumno.materias.create'])->syncRoles([$alumno]);  // VISUALIZACION DE LOS LOGROS
    }
}
