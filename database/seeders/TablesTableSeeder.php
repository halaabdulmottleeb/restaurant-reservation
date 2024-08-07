<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::factory()->count(50)->create();
    }
}
