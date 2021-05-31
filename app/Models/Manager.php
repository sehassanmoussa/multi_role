<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\User;

class Manager extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;
    public $table = 'manager';

    protected $fillable = [
        'manager_phone_number'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public static function createManager(Request $request , int $user_id){
        $manager = new Manager();
        $manager->manager_phone_number = $request['phone_number'];
        $manager->permission_level = config('permission_levels.manager');
        $manager->user_id = $user_id;
        $manager->save();
    }
}
