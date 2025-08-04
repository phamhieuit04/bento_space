<?php

namespace App\Services\Google\Drive;

use App\Exceptions\GoogleException;
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
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['pageSize' => 1000, 'fields' => "files({$this->fields})",]
        );
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect()['files'];
    }

    public function find(string $id)
    {
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . "/files/{$id}",
            ['fields' => $this->fields]
        );
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function update(string $id, string $name)
    {
        $response = Http::withToken($this->token)
            ->withQueryParameters(['fields' => $this->fields])
            ->patch(self::SERVICE_ENDPOINT . "/files/$id", ['name' => $name]);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function search(string $name)
    {
        $response = Http::withToken($this->token)->get(
            self::SERVICE_ENDPOINT . '/files',
            ['fields' => "files({$this->fields})", 'q' => "name contains '{$name}'"]
        );
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect()['files'];
    }

    public function upload(UploadedFile $file)
    {
        $response = Http::withToken($this->token)->withHeaders([
            'Content-Type' => $file->getClientMimeType(),
            'Content-Length' => $file->getSize()
        ])->withBody($file->getContent(), $file->getClientMimeType())
            ->withQueryParameters(['fields' => $this->fields])
            ->post(self::UPLOAD_FILE_URL . '/files', ['uploadType' => 'media']);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function download(string $id)
    {
        $response = Http::withToken($this->token)
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->body();
    }

    public function getRootId()
    {
        $response = Http::withToken($this->token)
            ->get(self::SERVICE_ENDPOINT . '/files/root', ['fields' => 'id']);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->json('id');
    }
}