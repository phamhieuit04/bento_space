<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'drive_id',
        'user_id',
        'name',
        'size',
        'video_url',
        'thumbnail_url',
        'icon_url',
        'mime_type',
        'parents_id',
        'created_at',
        'updated_at'
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'parents_id' => 'collection'
        ];
    }
}
