<?php

namespace BrngyWiFi\Http\Controllers;

use BrngyWiFi\Http\Controllers\Controller;
use BrngyWiFi\Modules\HomeownerAddress\Models\HomeownerAddress;
use BrngyWiFi\Modules\UserRoles\Models\UserRoles;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth as JWT;

class AuthenticateController extends Controller
{
    /**
     * @var JWT
     */
    protected $jwt;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(JWT $jwt, Guard $auth, Request $request)
    {
        $this->auth = $auth;
        $this->jwt = $jwt;
        $this->request = $request;
    }

    /**
     * Authorize the user
     *
     * @param ResponseFactory $response
     * @return array|\Illuminate\Http\Response
     */
    public function authorize(ResponseFactory $response)
    {
        $credentials = $this->request->only(['username', 'password']);

        if (!$this->auth->once($credentials)) {
            return ['result' => 'error', 'msg' => 'Invalid Credentials'];
        }

        $homeownerAddress = HomeownerAddress::where(['home_owner_id' => $this->auth->user()->id, 'primary' => 1])->get()->toArray()[0];

        return [
            'token' => 's731O3JcjneIlq0vjGvKUjKGGmlNH0PT7pwroj67', //$this->getUserToken($this->auth->user()),
            'userId' => $this->auth->user()->id,
            'userRole' => $this->getUserRole($this->auth->user()->id),
            'pin_code' => $this->auth->user()->pin_code,
            'notification' => $this->auth->user()->notification,
            'alert' => $this->auth->user()->alert,
            'email' => $this->auth->user()->email,
            'contact_no' => $this->auth->user()->contact_no,
            'homeowner_address_id' => $homeownerAddress['id'],
            'address' => $homeownerAddress['address'],
            'latitude' => $homeownerAddress['latitude'],
            'longitude' => $homeownerAddress['longitude'],
            'result' => 'success',
        ];
    }

    /**
     * Authorize the user via chikka
     *
     * @param ResponseFactory $response
     * @return array|\Illuminate\Http\Response
     */
    public function authorizeViaChikka($request)
    {
        //$credentials =  $request->only(['username', 'password']);

        if (!$this->auth->once(array('username' => $request['username'], 'password' => $request['password']))) {
            //return $response->make('Invalid credentials', 401);
            return ['result' => 'error'];
        }

        return [
            'token' => 's731O3JcjneIlq0vjGvKUjKGGmlNH0PT7pwroj67', //$this->getUserToken($this->auth->user()),
            'userId' => $this->auth->user()->id,
            'userRole' => $this->getUserRole($this->auth->user()->id),
            'pin_code' => $this->auth->user()->pin_code,
            'result' => 'success',
        ];
    }

    public function isAuthenticated(ResponseFactory $response)
    {
        return; // $response->make(['error' => 'token_invalid']);
    }

    /**
     * Refresh access tokens. This is a null route, the refreshing is handled
     * by middleware
     *
     * @return void
     */
    public function refreshToken()
    {
        return;
    }

    private function getUserRole($userId)
    {
        return UserRoles::where('user_id', $userId)->get()->toArray()[0]['role_id'];
    }

    protected function getUserToken($user)
    {
        return $this->jwt->fromUser($user, $this->createClaims($user));
    }

    protected function createClaims($user)
    {
        return [
            'username' => $user->username,
        ];
    }
}
