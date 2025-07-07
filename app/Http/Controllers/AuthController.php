<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function googleAuth()
    {
        $url = env('GOOGLE_OAUTH2_URL') .
            '?client_id=' . env('GOOGLE_CLIENT_ID') .
            '&redirect_uri=' . env('GOOGLE_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=email%20profile%20openid';
        return redirect()->away($url);
    }

    public function googleCallback(Request $request)
    {
        $params = $request->all();
        $tokenResponse = Http::asForm()->post(env('GOOGLE_API_TOKEN_URL'), [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'code' => $params['code'],
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('GOOGLE_REDIRECT_URL')
        ])->json();
        $accessToken = $tokenResponse['access_token'];
        $infoResponse = Http::withToken($accessToken)
            ->get(env('GOOGLE_USER_INFO_URL'))->json();
        return $infoResponse;
    }
}
