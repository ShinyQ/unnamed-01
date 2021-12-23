<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Exception;
use Api;

class UserController extends Controller
{
    private $response, $code;

    public function __construct()
    {
        $this->code = 200;
        $this->response = [];
    }

    public function index()
    {
        try{
            $this->response = Api::pagination(User::query());
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }

        return Api::apiRespond($this->code, $this->response);
    }

   public function register(UserRegisterRequest $request)
   {
        try{
            $data = $request->validated();
            $data['role'] = 'User';
            $data['password'] = bcrypt($data['password']);

            if ($request->role) $data['role'] = $request->role;
            $this->response = User::create($data);
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }

       return Api::apiRespond($this->code, $this->response);
   }

    public function login(UserLoginRequest $request)
    {
        try{
            $data = $request->validated();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = Auth::user();
                $user_data['user'] = $user;
                $user_data['token'] = $user->createToken('auth-api-find')->accessToken;
                $this->response = $user_data;
            } else {
                $this->code = 400;
                $this->response = ['Input Email Atau Password Anda Salah'];
            }

        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }

        return Api::apiRespond($this->code, $this->response);
    }
}
