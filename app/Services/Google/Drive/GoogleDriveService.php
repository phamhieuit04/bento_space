<?php

namespace App\Services\Google\Drive;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';
    const UPLOAD_FILE_URL = 'https://www.googleapis.com/upload/drive/v3';
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

    public function update(string $id, string $name)
    {
        $response = Http::withToken($this->token)->throw()
            ->withQueryParameters(['fields' => $this->fields])
            ->patch(self::SERVICE_ENDPOINT . "/files/$id", ['name' => $name]);
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

    public function upload(UploadedFile $file)
    {
        $response = Http::withToken($this->token)->withHeaders([
            'Content-Type' => $file->getClientMimeType(),
            'Content-Length' => $file->getSize()
        ])->withBody($file->getContent(), $file->getClientMimeType())
            ->throw()->post(self::UPLOAD_FILE_URL . '/files', ['uploadType' => 'media']);
        return $response->json('id');
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
            ->get(self::SERVICE_ENDPOINT . '/files/root', ['fields' => 'id']);
        return $response->json('id');
    }
}