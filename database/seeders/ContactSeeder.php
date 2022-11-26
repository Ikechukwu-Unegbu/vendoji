<?php

namespace Database\Seeders;

use App\Models\V1\extras\Contact;
use App\Models\V1\extras\Inquiry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory(20)->create();
    }
}
