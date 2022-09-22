<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SLID01SlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'title' => 'Título Banner',
            'subtitle' => 'Subtítulo Banner',
            'description' => 'Donec diam enim, rhoncus sed gravida et',
            'title_button' => 'Call to Action',
            'link_button' => 'https://www.lipsum.com/',
            'active' => 1,
        ]);
    }
}
