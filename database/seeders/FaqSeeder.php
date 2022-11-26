<?php

namespace Database\Seeders;

use App\Models\V1\extras\Faq;
use App\Models\V1\extras\Faqcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cates = Faqcategory::all();

        foreach($cates as $cate){
            Faq::factory(4)->create([
                'category_id'=>$cate->id
            ]);
        }
    }
}
