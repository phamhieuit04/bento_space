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
        $this->token = Auth::user()->google_token;
        $this->fields = 'id,name,mimeType,size,thumbnailLink,createdTime,modifiedTime,parents';
    }

    public function all()
    {
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['pageSize' => 1000, 'fields' => "files({$this->fields})",]
        )->json();
        return collect($response['files']);
    }

    public function find(string $id)
    {
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . "/files/{$id}",
            ['fields' => $this->fields]
        )->collect();
        return $response;
    }

    public function findByName(string $name)
    {
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['fields' => "files({$this->fields})", 'q' => "name = '{$name}'"]
        )->json();
        return collect($response['files'][0]);
    }

    public function download(string $id)
    {
        $response = Http::withToken($this->token)
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        Storage::put(self::find($id)['name'], $response->body());
        return true;
    }

    public function getRootId()
    {
        $response = Http::withToken($this->token)
            ->get(self::SERVICE_ENDPOINT . '/files/root', ['fields' => 'id'])
            ->json();
        return $response['id'];
    }
}