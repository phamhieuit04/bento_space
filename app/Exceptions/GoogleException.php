<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class GoogleException extends Exception
{
    public function __construct(protected Response $response)
    {
        $this->message = $response;
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('[Google]:', $this->response);
    }
}
