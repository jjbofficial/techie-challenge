<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Support\Str;

/**
 * @tags Auth
 */
class LoginController extends Controller
{
    /**
     * @unauthenticated
     *
     * Login
     */
    public function __invoke(LoginRequest $request)
    {
        $user = $request->authenticatedUser;

        $token = $user->createToken(Str::random(10))
            ->plainTextToken;

        return response()->json([
            ...(new UserResource($user))->toArray($request),
            'token' => $token
        ]);
    }
}
