<?php

namespace App\Models\V1\transactions;

use App\Models\V1\Core\Unlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Wallet extends Model
{
    protected $table = 'wallets';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'id', 'user_id');
    }

    public function unlock(){
        $this->hasMany(Wallet::class);
    }
}
