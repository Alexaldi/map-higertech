<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StationSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(ClientPartnerSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
