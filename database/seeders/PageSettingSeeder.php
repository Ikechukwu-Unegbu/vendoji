<?php

namespace Database\Seeders;

use App\Models\PageSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'key'  =>  'contact_address',
                'value' => 'A108 Adam Street, New York, NY 535022'
            ],[
                'key'   =>  'contact_mobile',
                'value' =>  '+1 5589 55488 55'
            ], [
                'key'   =>  'contact_email',
                'value' =>  'info@vendoji.com contact@vendoji.com'
            ], [
                'key'   =>  'contact_open_hour',
                'value' =>  'Monday - Friday 9:00AM - 05:00PM'
            ], [
                'key'   =>  'site_logo',
                'value' =>  'logo.png'
            ]
        ];

        PageSetting::insert($data);
    }
}
