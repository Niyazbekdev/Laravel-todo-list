<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class StoreTask extends BaseService
{
    public function rules(): array
    {
        return [
            'title'=> 'required|unique:tasks,title',
            'description' => 'nullable',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data)
    {

        $this->validate($data);
        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return $task;
    }
}
