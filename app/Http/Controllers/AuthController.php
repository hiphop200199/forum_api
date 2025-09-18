<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Struct\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Constant\StatusCode;
use App\Constant\StatusDescription;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Constant\Number;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    private $response;

    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            session_start();

            $googleUser = Socialite::driver('google')->user();
            $user = Account::where('google_id', '=', $googleUser->id)->first();

            if (empty($user)) {
                $newUser = Account::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('1234'),
                    'google_id' => $googleUser->id,
                    'create_time' => time(),
                    'update_time' => time()
                ]);

                session_regenerate_id();
                setcookie('member', $newUser['id'] . '|' . hash('sha256', $newUser['id'] . $newUser['email'] . $newUser['password'] . time())  . '|' . time(), time() + Number::ONE_DAY, '/', '', false, true);


                $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($newUser);
            } else {
                session_regenerate_id();
                setcookie('member', $user['id'] . '|' . hash('sha256', $user['id'] . $user['email'] . $user['password'] . time())  . '|' . time(), time() + Number::ONE_DAY, '/', '', false, true);


                $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($user);
            }
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode($th->getCode());
        } finally {
            return ['response' => $this->response];
        }



        //如果使用者已存在，就直接登入，否則建立新資料後登入


    }
    public function login(Request $request)
    {
        try {
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
            $password = hash('sha256', $input['password']);
            $member = Account::getByEmailAndPassword($input['email'], $password);
            if (empty($member)) {
                throw new Exception('帳號或密碼錯誤', StatusCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            //表示合格，將派發已登入認證token，並導引畫面到員工帳號列表頁
            session_regenerate_id();
            setcookie('member', $member['id'] . '|' . hash('sha256', $member['id'] . $member['email'] . $member['password'] . time())  . '|' . time(), time() + Number::ONE_DAY, '/', '', false, true);


            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($member);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode($th->getCode());
        } finally {
            return ['response' => $this->response];
        }
    }

    public function register(Request $request)
    {
        try {
            $input = $request->all();

            $rules = [
                'nickname' => [
                    'required',
                    'string',
                ],
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
            $input['password'] = hash('sha256', $input['password']);
            $input['create_time'] = time();
            $input['update_time'] = time();
            $member = Account::create($input);
            session_regenerate_id();
            setcookie('member', $member['id'] . '|' . hash('sha256', $member['id'] . $member['email'] . $member['password'] . time())  . '|' . time(), time() + Number::ONE_DAY, '/', '', false, true);


            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($member);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode($th->getCode());
        } finally {
            return ['response' => $this->response];
        }
    }

    public function checkLogin(Request $request)
    {
        try {

            $userInfo = $request->attributes->get('userInfo');


            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($userInfo);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode($th->getCode());
        } finally {
            return ['response' => $this->response];
        }
    }

    public function logout()
    {
        try {

            setcookie('member', '', time() - Number::ONE_DAY, '/', '', false, true);

            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode($th->getCode());
        } finally {
            return ['response' => $this->response];
        }
    }
}
