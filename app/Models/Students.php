<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;



class Students extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'students';

    protected $fillable = [
        'firstname',
        'lastname',
        'image',
        'date',
        'salary',
        'role_id',
    ];
}
