<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'CENTRO MEDICO SAMA',
            'email' => 'admin@sama.com.pe',
        ]);

        User::factory()->create([
            'name' => 'EPIFANIO FERNANDEZ VENTURA',
            'email' => '2019110516@udh.edu.pe',
        ]);

        User::factory(10)->create();
    }
}
