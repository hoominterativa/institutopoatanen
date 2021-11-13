<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SLID01Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slid01_slides')->insert([
            'title' => 'Titulo Principal informado aqui',
            'subtitle' => 'sub-titulo',
            'description' => 'Home is behind, the world ahead and there are many paths to tread through shadows to the edge.',
            'path_image_background' => 'uploads/tmp/slide_background.jpg',
            'path_image_png' => 'uploads/tmp/slide_png.jpg',
            'active' => 1,
        ]);
    }
}
