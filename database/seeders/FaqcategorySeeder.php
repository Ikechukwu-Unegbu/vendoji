<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FaqcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqcategories')->insert([
            'name' => 'Staking',
            'description' => 'Random Description'
            // 'password' => Hash::make('password'),
        ]);
        DB::table('faqcategories')->insert([
            'name' => 'Bitcoin',
            'description' => 'Random Description'
            // 'password' => Hash::make('password'),
        ]);
    }
}
