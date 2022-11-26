<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\V1\Bank\Banktransfer;
use App\Models\V1\Core\Unlock;
use App\Models\V1\Core\Userlock;
use App\Models\V1\extras\Image;
use App\Models\V1\transactions\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Spatie\ActivityLog\Traits\LogsActivity;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $image;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image()
    {
        return ($this->image != '' || $this->image != null) ? url("{$this->image}") : url('no-image/no-image.png');
    }

    public function kin()
    {
        return $this->belongsTo(\App\Models\V1\extras\Kin::class, 'user_id');
    }
    public function getMReferrer($id){
        $user = self::find($id);
        $refs = self::where('myref', $user->mycode)->get();
        return count($refs);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function banktransfer(){
        return $this->hasMany(Banktransfer::class);
    }

    public function banktransfers(){
        return $this->hasMany(Banktransfer::class, 'user_id');
    }

    public function userlock(){
        return $this->hasMany(Userlock::class);
    }

    public function unlock(){
        return $this->hasMany(Unlock::class);
    }




}
