<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\User;

class Client extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'client';
    protected $fillable = [
        'client_phone_number'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function createClient(Request $request , int $user_id){
        $client = new Client();
        $client->client_phone_number = $request['phone_number'];
        $client->permission_level = config('permission_levels.client');
        $client->user_id = $user_id;
        $client->save();
    }
}
