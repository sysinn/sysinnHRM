<?php

namespace Database\Seeders;
use App\Models\MenuItem;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::create([
            'label' => 'Dashboard',
            'route' => 'auth.dashboard',
            'icon' => 'home',
            'roles' => [1, 2],
        ]);

    }
}
