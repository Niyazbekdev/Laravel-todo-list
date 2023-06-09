<?php

namespace App\Http\Controllers;

use App\Services\User\LoginUser;
use App\Services\User\RegisterUser;
use Illuminate\Http\Request;
use App\Traits\JsonRespondController;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use JsonRespondController;
    public function register(Request $request){
        try{
            [$user, $token] = app(RegisterUser::class)->execute($request->all());
            return response([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'token' => $token,
                ]
                ]);
        }catch(ValidationException $exception){
            return $this->respondValidatorFailed($exception->validator);
        }
    }

    public function login(Request $request){
        try{
            [$user, $token] = app(LoginUser::class)->execute($request->all());
            return [
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'token' => $token,
                ],
            ];
            }catch (ValidationException $exception){
                return response([
                    'errors' => $exception->validator->errors()->all()
                ]);
            }catch (\Exception $exception){
                if($exception->getCode() == 401){
                    return response([
                        'errors' => $exception->getMessage()
                    ], $exception->getCode());
                }
            }
    }
}
