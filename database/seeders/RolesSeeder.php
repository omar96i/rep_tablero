<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'superadmin']);
        $role2 = Role::create(['name'=>'administrador']);
        $role3 = Role::create(['name'=>'subgerencia.financiera']);
        $role4 = Role::create(['name'=>'subgerencia.planeacion']);
        $role5 = Role::create(['name'=>'subgerencia.proyectos']);


        //Usuario
        Permission::create(['name'=>'ver_usuario'])->assignRole($role1, $role2);
        Permission::create(['name'=>'crear_usuario'])->assignRole($role1, $role2);
        Permission::create(['name'=>'editar_usuario'])->assignRole($role1, $role2);
        Permission::create(['name'=>'eliminar_usuario'])->assignRole($role1, $role2);

        //Administracion
        Permission::create(['name'=>'ver_administracion'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'crear_administracion'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'editar_administracion'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'eliminar_administracion'])->syncRoles([$role1, $role2]);

        // Programacion
        Permission::create(['name'=>'ver_programacion'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name'=>'crear_programacion'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name'=>'editar_programacion'])->syncRoles([$role1, $role2, $role5]);
        Permission::create(['name'=>'eliminar_programacion'])->syncRoles([$role1, $role2, $role5]);

        //PlanOperativo
        Permission::create(['name'=>'ver_plan_operativo'])->syncRoles([$role1, $role3, $role5]);
        Permission::create(['name'=>'crear_plan_operativo'])->syncRoles([$role1, $role3, $role5]);
        Permission::create(['name'=>'editar_plan_operativo'])->syncRoles([$role1, $role3, $role5]);
        Permission::create(['name'=>'eliminar_plan_operativo'])->syncRoles([$role1, $role3, $role5]);

        //Ejecucion
        Permission::create(['name'=>'ver_ejecucion'])->syncRoles([$role1, $role4]);
        Permission::create(['name'=>'crear_ejecucion'])->syncRoles([$role1, $role4]);
        Permission::create(['name'=>'editar_ejecucion'])->syncRoles([$role1, $role4]);
        Permission::create(['name'=>'eliminar_ejecucion'])->syncRoles([$role1, $role4]);

        $user1 = User::create([
            'nombre' => 'Super Administrador',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'superadmin@gmail.com',
            'usuario'=>'superadmin',
            'password' => 'sup3r4adm1n2024',
        ]);
        $user1->assignRole($role1);

        $user2 = User::create([
            'nombre' => 'Administrador',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'administrador@gmail.com',
            'usuario'=>'administrador',
            'password' => '4dm1n1str4d0r2024',
		]);
        $user2->assignRole($role2);

        $user3 = User::create([
            'nombre' => 'Subgerencia Financiara',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.financiera@gmail.com',
            'usuario'=>'subgerencia.financiera',
            'password' => 'f1n4nc13r42024',
		]);
        $user3->assignRole($role3);

        $user4 = User::create([
            'nombre' => 'Subgerencia Planeacion',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.planeacion@gmail.com',
            'usuario'=>'subgerencia.planeacion',
            'password' => 'pl4n34c10n2024',
		]);
        $user4->assignRole($role4);

        $user5 = User::create([
            'nombre' => 'Subgerencia Proyectos',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.proyectos@gmail.com',
            'usuario'=>'subgerencia.proyectos',
            'password' => 'pr0y3ct0s2024',
		]);
        $user5->assignRole($role5);
    }
}
