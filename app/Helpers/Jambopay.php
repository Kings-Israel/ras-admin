<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Jambopay {
    public static function walletAccessToken()
    {
        $url = config('services.jambopay.wallet_auth_url').'/auth/token';
        $response = Http::asForm()->post($url, [
            'client_id' => config('services.jambopay.wallet_client_id'),
            'client_secret' => config('services.jambopay.wallet_client_secret'),
            'grant_type' => 'client_credentials'
        ]);

        return json_decode($response);
    }

    public static function currencies()
    {
        $token = self::walletAccessToken();
        $url = config('services.jambopay.wallet_url').'/settings/currencies';

        $currencies = Http::withHeaders([
                                'Authorization' => $token->token_type.' '.$token->access_token
                            ])
                            ->get($url);

        return $currencies['data'];
    }
}
