<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\User;
use App\Models\UserProfile;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use League\Flysystem\Exception;
use League\OAuth2\Server\Exception\OAuthServerException;

use function GuzzleHttp\json_decode;

class AuthController extends ApiController
{
    const ACCESS_TOKEN_COOKIE = '_token';
    const REFRESH_TOKEN_COOKIE = '_refreshToken';

    protected function generateAccessToken($user)
    {
        $token = $user->createToken($user->email . '-' . now());

        return $this->showMessage($token->accessToken);
    }

    public function register(Request $request)
    {
        Log::debug($request);
        $rules = [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = false;

        $user = User::create($data);

        // return $this->showOne($user, 201);
        return new UserResource($user);
    }

    public function login(Request $request)
    {
        // Log::debug($request);
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // $token = $user->createToken($user->email . '-' . now());

            $innerRequest = Request::create('/oauth/token', 'POST');
            $request->request->add([
                'username' => $request->email,
                'client_id' => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'grant_type' => 'password'
            ]);

            $response = Route::dispatch($innerRequest);
            if ($response->status() !== 200) {
                $content = json_decode($response->content());
                throw new AuthenticationException($content->error_description);
            }

            $response = json_decode($response->content());

            // Log::debug($response);

            Cookie::queue(self::ACCESS_TOKEN_COOKIE, $response->access_token);
            Cookie::queue(self::REFRESH_TOKEN_COOKIE, $response->refresh_token);

            return $this->successResponse([
                'user' => new UserResource($user),
                'token' =>  $response->access_token,
                'expires_in' =>  $response->expires_in,
                'refresh_token' => $response->refresh_token,
            ], 200);
        }
    }

    public function refresh(Request $request)
    {
        if (!$request->hasCookie(self::REFRESH_TOKEN_COOKIE)) {
            return $this->errorResponse('No refresh token', 401);
        }

        $token = $request->cookie(self::REFRESH_TOKEN_COOKIE);

        $innerRequest = Request::create('/oauth/token', 'POST');
        $request->request->add([
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $token
        ]);


        $response = Route::dispatch($innerRequest);
        // Log::debug($response);
        // Log::debug($response->status());
        // Log::debug($response->content());

        if ($response->status() !== 200) {
            $content = json_decode($response->content());
            throw new AuthenticationException($content->error_description);
        }

        $response = json_decode($response->content());

        Cookie::queue(self::ACCESS_TOKEN_COOKIE, $response->access_token);
        Cookie::queue(self::REFRESH_TOKEN_COOKIE, $response->refresh_token);

        return $this->successResponse([
            'token' =>  $response->access_token,
            'expires_in' =>  $response->expires_in,
            'refresh_token' => $response->refresh_token,
        ], 200);
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget(self::ACCESS_TOKEN_COOKIE));
        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN_COOKIE));

        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();

        return response()->json(['success' => 'success']);
    }

    public function currentUser()
    {
        $user = Auth::user();
        if ($user) {
            // return $this->showOne($user);
            return new UserResource($user);
        }

        return $this->errorResponse('User not found!!', 404);
    }
}
