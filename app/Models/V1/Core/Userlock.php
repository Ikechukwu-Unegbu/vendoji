<?php

namespace App\Models\V1\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\V1\Core\Unlock;

class Userlock extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function unlock(){
        return $this->hasOne(Unlock::class);
    }


}
