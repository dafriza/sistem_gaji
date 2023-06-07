<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Salary;
use App\Models\Kehadiran;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionDemoSeeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionDemoSeeder::class,
        ]);
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create()->assignRole('karyawan');
            Kehadiran::factory()
                ->count(30)
                ->for($user)
                ->create();
        }
    }
}
