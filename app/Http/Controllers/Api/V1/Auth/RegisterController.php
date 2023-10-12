<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @tags Auth
 *
 */
class RegisterController extends Controller
{
    /**
     * @unauthenticated
     *
     * Register
     *
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create(
            $request->safe()
                ->merge([
                    'password' => bcrypt($request->password)
                ])
                ->toArray()
        );

        $token = $user->createToken(Str::random(10))
            ->plainTextToken;

        return response()->json([
            ...(new UserResource($user))->toArray($request),
            'token' => $token
        ]);
    }
}
