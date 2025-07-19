<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class GoogleException extends Exception
{
    public function __construct(protected Response $response)
    {
        $this->message = "[Error]: {$response->json('error')}. " .
            "[Description]: {$response->json('error_description')}.";
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('[Google]:', [
            'status' => $this->response->status(),
            'error' => $this->response->json('error'),
            'description' => $this->response->json('error_description')
        ]);
    }
}

