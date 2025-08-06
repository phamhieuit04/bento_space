<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'drive_id',
        'user_id',
        'name',
        'size',
        'download_url',
        'video_url',
        'thumbnail_url',
        'icon_url',
        'mime_type',
        'extension',
        'parents_id',
        'trashed',
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

    protected function size(): Attribute
    {
        return Attribute::make(
            fn(int $value) => Number::fileSize($value)
        );
    }
}
