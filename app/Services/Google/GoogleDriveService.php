<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class GoogleDriveService
{
    const SERVICE_ENDPOINT = 'https://www.googleapis.com/drive/v3';

    public function get(string $accessToken, array $params = null)
    {
        return Http::withToken($accessToken)
            ->get(self::SERVICE_ENDPOINT . '/files', $params)
            ->collect();
    }

    public function find($id, string $accessToken)
    {
        return self::get($accessToken)
            ->map(fn($file) => collect($file)
                ->where('id', $id)->values())['files'][0];
    }
    public function findByName(string $name, string $accessToken)
    {
        return self::get($accessToken)
            ->map(fn($file) => collect($file)
                ->where('name', $name)->values())['files'][0];
    }

    public function download(int $id, string $filename, string $accessToken)
    {
        $downloadResponse = Http::withToken($accessToken)
            ->get(self::SERVICE_ENDPOINT . "/files/{$id}", [
                'alt' => 'media'
            ]);
        Storage::put($filename, $downloadResponse->body());
        return true;
    }
}