<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';
    private $accessToken;
    private $fields;

    public function __construct()
    {
        $this->accessToken = Auth::user()->google_token;
        $this->fields = 'id,name,mimeType,size,thumbnailLink,createdTime,modifiedTime,parents';
    }

    public function all()
    {
        return collect(Http::withToken($this->accessToken)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['pageSize' => 1000, 'fields' => "files({$this->fields})",]
        )->json()['files']);
    }

    // TODO: add getFolders and getFiles functions

    public function find(string $id)
    {
        return Http::withToken($this->accessToken)->get(
            self::SERVICE_ENDPOINT . "/files/{$id}",
            ['fields' => $this->fields]
        )->collect();
    }

    public function findByName(string $name)
    {
        return collect(Http::withToken($this->accessToken)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['fields' => "files({$this->fields})", 'q' => "name = '{$name}'"]
        )->json()['files'][0]);
    }

    public function download(string $id)
    {
        $response = Http::withToken($this->accessToken)
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        Storage::put(self::find($id)['name'], $response->body());
        return true;
    }
}