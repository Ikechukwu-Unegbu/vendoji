<?php

namespace App\Models\V1\Core;

use App\Models\User;
use App\Models\V1\transactions\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unlock extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userlock(){
        return $this->belongsTo(Userlock::class, 'lock_id');
    }

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
}
