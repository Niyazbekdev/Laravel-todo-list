<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Validation\ValidationException;
class LoginUser extends BaseService
{
    public function rules(): array
    {
        return [
            'phone' => 'required,',
            'password' => 'required',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data): array
    {
        $this->validate($data);
        $user = User::where('phone', $data['phone'])->first();
        if(!$user or !Hash::check($data['password'], $user->password)){
            throw new Exception('user not found or password in correct');
        }
        $token = $user->createToken('user model')->plainTextToken;
        return [$user, $token];
    }
}
