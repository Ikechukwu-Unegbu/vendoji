<?php

namespace App\Models\V1\Bank;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banktransfer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function masterWallet()
    {
        return $this->belongsTo(\App\Models\SiteSetting::class, 'master_wallet_id');
    }

    public function userWallet()
    {
        return $this->belongsTo(\App\Models\V1\transactions\Wallet::class, 'user_wallet_id');
    }
}
