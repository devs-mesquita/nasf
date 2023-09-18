<?php

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
        DB::table('users')->insert([
            'name' => 'Victor Mussel',
            'email' => 'victor.mussel@mesquita.rj.gov.br',
            'nivel' => 'Medico',
            'password' => '$2y$10$6mbLoOetfWa6538CSyUIxOJfLEOaeofzXXNgZujBxSTtH1GdO75sm',
        ]);
    }
}
