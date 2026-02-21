<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $rolAdmin = DB::table('roles')
            ->where('nombre_rol', 'administrador')
            ->first();

        DB::table('usuarios')->insert([
            'cod_rol' => $rolAdmin->cod_rol,
            'nombre_usuario' => 'admin',
            'nombre_completo' => 'Administrador General',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}