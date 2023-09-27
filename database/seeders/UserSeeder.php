<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nombre' => 'Super Administrador',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'superadmin@gmail.com',
            'usuario'=>'superadmin',
            'password' => 'sup3r4adm1n2024',
            'remember_token'=>NULL,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
		]);
        DB::table('users')->insert([
            'nombre' => 'Administrador',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'administrador@gmail.com',
            'usuario'=>'administrador',
            'password' => '4dm1n1str4d0r2024',
            'remember_token'=>NULL,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
		]);
        DB::table('users')->insert([
            'nombre' => 'Subgerencia Financiara',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.financiera@gmail.com',
            'usuario'=>'subgerencia.financiera',
            'password' => 'f1n4nc13r42024',
            'remember_token'=>NULL,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
		]);
        DB::table('users')->insert([
            'nombre' => 'Subgerencia Planeacion',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.planeacion@gmail.com',
            'usuario'=>'subgerencia.planeacion',
            'password' => 'pl4n34c10n2024',
            'remember_token'=>NULL,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
		]);
        DB::table('users')->insert([
            'nombre' => 'Subgerencia Proyectos',
            'apellido'=>'',
            'documento'=>'',
            'email' => 'subgerencia.proyectos@gmail.com',
            'usuario'=>'subgerencia.proyectos',
            'password' => 'pr0y3ct0s2024',
            'remember_token'=>NULL,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
		]);
    }
}
