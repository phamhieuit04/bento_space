<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Http;

class GoogleService
{
    const GOOGLE_OAUTH2_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    const GOOGLE_API_TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const GOOGLE_USER_INFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';
    const GOOGLE_SCOPE_DRIVE = 'https://www.googleapis.com/auth/drive';

    public function getOAuthUrl()
    {
        return self::GOOGLE_OAUTH2_URL .
            '?client_id=' . env('GOOGLE_CLIENT_ID') .
            '&redirect_uri=' . env('GOOGLE_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=email%20profile%20openid%20' . self::GOOGLE_SCOPE_DRIVE .
            "&prompt=select_account";
    }

    public function getAccessToken(string $code)
    {
        $tokenResponse = Http::asForm()->post(self::GOOGLE_API_TOKEN_URL, [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('GOOGLE_REDIRECT_URL')
        ])->json();
        return $tokenResponse['access_token'];
    }

    public function getAccountInfo(string $accessToken)
    {
        return Http::withToken($accessToken)
            ->get(self::GOOGLE_USER_INFO_URL)->collect();
    }
}