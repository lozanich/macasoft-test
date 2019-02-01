<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Roles::create([
          'id' => '1',
          'id_rol' => '1',
          'rol' => 'administrador',
        ]);

        \App\Models\Roles::create([
          'id' => '2',
          'id_rol' => '2',
          'rol' => 'usuario',
        ]);

        \App\Models\Roles::create([
          'id' => '3',
          'id_rol' => '3',
          'rol' => 'vendedor',
        ]);
    }
}
