<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Roles extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'roles';

    protected $fillable = [
        'role_name',
        'role_slug',
    ];
}
