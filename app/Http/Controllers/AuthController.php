<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Constant\StatusCode;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
            session_start();

            $googleUser = Socialite::driver('google')->user();

            $user = Account::where('google_id', '=', $googleUser->id)->first();

            session_regenerate_id();
            if (empty($user)) {
                $newUser = Account::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => hash('sha256','1234'),
                    'google_id' => $googleUser->id,
                    'create_time' => time(),
                    'update_time' => time()
                ]);
                $_SESSION['user'] = $newUser;
                $_SESSION['name'] = $newUser->name;
            } else {
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $user->name;
            }
            return view('home');
    }
    public function login(Request $request)
    {
            $input = $request->all();

            $rules = [
                'email' => [
                    'required',
                    'string'
                ],
                'password' => [
                    'required',
                    'string'
                ],
            ];
            $validator =  Validator::make($input, $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            session_start();

            //檢查帳密是否正確
            $password = hash('sha256',$input['password']);
            $member = Account::getByEmailAndPassword($input['email'], $password);
            if (empty($member)) {
                throw new Exception('帳號或密碼錯誤', StatusCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            //表示合格，將派發已登入認證token，並導引畫面到員工帳號列表頁
            session_regenerate_id();
            $_SESSION['user'] = $member;
            $_SESSION['name'] = $member->name;
            return view('home');
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        return view('home');
    }

}
