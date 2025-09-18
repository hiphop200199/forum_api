<?php

namespace App\Http\Controllers;

use App\Constant\StatusCode;
use App\Constant\StatusDescription;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use App\Struct\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class ArticleCommentController extends Controller
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
                'article_id' => [
                    'required',
                    'numeric'
                ],
            ];
            $validator =  Validator::make($input, $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $result = ArticleComment::getList($input['article_id']);

            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS)->setData($result);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode(StatusCode::FAIL);
        } finally {
            return ['response' => $this->response];
        }
    }

    public function add(Request $request)
    {
        try {
            $input = $request->all();
            $rules = [
                'account_id' => [
                    'required',
                    'numeric',
                ],
                'article_id' => [
                    'required',
                    'numeric',
                ],
                'content' => [
                    'required',
                    'string',
                ],
            ];
            $validator =  Validator::make($input, $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $input['content'] = htmlspecialchars(strip_tags($input['content']));
            $input['create_time'] = time();
            $input['update_time'] = time();
            ArticleComment::create($input);

            $this->response->setMessage(StatusDescription::SUCCESS)->setCode(StatusCode::SUCCESS);
        } catch (ValidationException $ve) {
            $this->response->setMessage($ve->getMessage())->setCode(StatusCode::FORMAT_ERROR);
        } catch (\Throwable $th) {
            $this->response->setMessage($th->getMessage())->setCode(StatusCode::FAIL);
        } finally {
            return ['response' => $this->response];
        }
    }


}
