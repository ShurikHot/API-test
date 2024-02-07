<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function __invoke()
    {
        $credentials = [
            'email' => 'admin@admin.com',
            'password' => '111',
        ];
        if (!Auth::attempt($credentials)) {
            return 'The provided credentials do not match our records';
        }

        $admin = Auth::user();

        if ($admin->tokens) {
            foreach ($admin->tokens as $token) {
                if ($token->expires_at && $token->expires_at->isPast()) {
                    $token->delete();
                }
            }
        }

        $allTokens = $admin->tokens;

        if (count($allTokens) > 0) {
            $token = $allTokens->last()->token;
        } else {
            $token = $admin->createToken($admin['name'], expiresAt: now()->addMinutes(40))->accessToken->token;
        }

        return response()
            ->json([
                'success' => true,
                'token' => $token
            ], 200);
    }
}
