<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OptimizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('optimizations')->insert([
            'author' => 'Hoom interativa',
            'title' => 'Hoom interativa - Sistemas',
            'description' => 'Hoom interativa - Sistemas',
            'keywords' => '--',
        ]);
    }
}
