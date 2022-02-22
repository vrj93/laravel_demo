<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class ApiUser extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password'
    ];
}
