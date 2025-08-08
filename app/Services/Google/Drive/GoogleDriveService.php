<?php

namespace App\Services\Google\Drive;

use App\Exceptions\GoogleException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';
    const UPLOAD_SERVICE_ENDPOINT = 'https://www.googleapis.com/upload/drive/v3';
    private $token;
    private $fields;

    public function __construct()
    {
        $this->token = Auth::user()->access_token;
        $this->fields = 'id,name,fullFileExtension,webContentLink,mimeType,size,thumbnailLink,iconLink,parents,trashed,createdTime,modifiedTime';
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

    public function update(string $id, array $data)
    {
        $response = Http::withToken($this->token)
            ->withQueryParameters(['fields' => $this->fields])
            ->patch(self::SERVICE_ENDPOINT . "/files/$id", $data);
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
            ->post(self::UPLOAD_SERVICE_ENDPOINT . '/files', ['uploadType' => 'media']);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function stream(string $id)
    {
        $response = Http::withToken($this->token)
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", ['alt' => 'media']);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->body();
    }

    public function restore($id)
    {
        return $this->update($id, ['trashed' => false]);
    }

    public function delete($id)
    {
        return $this->update($id, ['trashed' => true]);
    }

    public function hardDelete($id)
    {
        $response = Http::withToken($this->token)
            ->delete(self::SERVICE_ENDPOINT . "/files/$id");
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return true;
    }

    public function emptyTrash()
    {
        $response = Http::withToken($this->token)
            ->delete(self::SERVICE_ENDPOINT . '/files/trash');
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return true;
    }

    public function createFolder(string $name)
    {
        $response = Http::withToken($this->token)->post(self::SERVICE_ENDPOINT . "/files", [
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);
        if ($response->failed()) {
            throw new \Exception($response);
        }
        return $response->collect();
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
