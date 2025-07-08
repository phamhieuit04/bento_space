<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleToken extends Model
{
    protected $table = 'google_tokens';

    protected $fillable = [
        'token',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
