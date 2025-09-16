<?php

namespace App\Http\Controllers;

use App\Constant\StatusCode;
use App\Constant\StatusDescription;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Service\OrderService;
use App\Struct\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class ArticleController extends Controller
{
    private $response;

    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }
    public function index(Request $request)
    {
        try {
            $input = $request->all();

            $rules = [
                'text' => [
                    'string'
                ],
            ];
            $validator =  Validator::make($input, $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $result = Article::getList($input['text']);

            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($result);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode(StatusCode::FAIL);
        } finally {
            return ['response' => $this->response];
        }
    }

    public function get($id)
    {
        try {
            $input = ['id' => $id];
            $rules = [
                'id' => [
                    'required',
                    'numeric'
                ],
            ];
            $validator =  Validator::make($input, $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $result = Article::find($id);

            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($result);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode(StatusCode::FAIL);
        } finally {
            return ['response' => $this->response];
        }
    }
}
