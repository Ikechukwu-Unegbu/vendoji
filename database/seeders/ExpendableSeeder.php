<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\V1\Core\Refrule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpendableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        // foreach($users as $user){
        //     $user->mycode = rand(1000, 9999);
        //     $user->save();
        // }
        $refrule = new Refrule();
        $refrule->reward = 5;
        $refrule->min_amount = 8000;
        $refrule->save();
        
        
    }
}
