<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Lote::factory(200)->create();
        //\App\Models\Familia::factory(3000)->create();
        //\App\Models\Beneficiario::factory(1000)->create();
        $this->call([
            UserSeeder::class,
            escolaridadeSeeder::class,
            estadocivilSeeder::class,
            ProfissaoSeeder::class,
            DocumentSeeder::class,
            tagSeeder::class,
            MenuSeeder::class,
            PermissionSeeder::class,
            QoptionSeeder::class,
        ]);

    }
}
