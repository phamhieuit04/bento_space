<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';
    private $token;
    private $fields;

    public function __construct()
    {
        $this->token = Auth::user()->access_token;
        $this->fields = 'id,name,mimeType,size,thumbnailLink,iconLink,parents,createdTime,modifiedTime';
    }

    public function all()
    {
        $response = Http::withToken($this->token)->throw()->get(
            self::SERVICE_ENDPOINT . '/files',
            ['pageSize' => 1000, 'fields' => "files({$this->fields})",]
        );
        return $response->collect()['files'];
    }

    public function find(string $id)
    {
        $response = Http::withToken($this->token)->throw()->get(
            self::SERVICE_ENDPOINT . "/files/{$id}",
            ['fields' => $this->fields]
        );
        return $response->collect();
    }

    public function findByName(string $name)
    {
        $response = Http::withToken($this->token)->throw()->get(
            self::SERVICE_ENDPOINT . '/files',
            ['fields' => "files({$this->fields})", 'q' => "name = '{$name}'"]
        );
        return $response->collect()['files'][0];
    }

    public function download(string $id)
    {
        $response = Http::withToken($this->token)->throw()
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        Storage::put(self::find($id)['name'], $response->body());
        return true;
    }

    public function getRootId()
    {
        $response = Http::withToken($this->token)->throw()
            ->get(self::SERVICE_ENDPOINT . '/files/root', ['fields' => 'id'])->json();
        return $response['id'];
    }
}