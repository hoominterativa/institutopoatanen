<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TOPI01SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topi01section_topics')->insert([
            'title' => 'Titulo Chamada',
            'description' => 'Home is behind, the world ahead and there are many paths to tread through shadows to the edge, world ahead and there are.',
            'active' => 1,
        ]);
    }
}
