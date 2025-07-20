<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';
    const THUMBNAIL_URL = 'https://drive.google.com/thumbnail';
    const FILE_URL = 'https://drive.google.com/file';
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

    public function search(string $name)
    {
        $response = Http::withToken($this->token)->throw()->get(
            self::SERVICE_ENDPOINT . '/files',
            ['fields' => "files({$this->fields})", 'q' => "name contains '{$name}'"]
        );
        return $response->collect()['files'];
    }

    public function download(string $id)
    {
        $response = Http::withToken($this->token)->throw()
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        return $response->body();
    }

    public function getRootId()
    {
        $response = Http::withToken($this->token)->throw()
            ->get(self::SERVICE_ENDPOINT . '/files/root', ['fields' => 'id'])->json();
        return $response['id'];
    }

    public function getImageUrl(string $id)
    {
        return self::THUMBNAIL_URL . "?id={$id}&sz=w1000";
    }

    public function getVideoUrl(string $id)
    {
        return self::FILE_URL . "/d/{$id}/preview";
    }
}