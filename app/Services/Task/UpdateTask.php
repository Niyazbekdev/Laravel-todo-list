<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\BaseService;
use Illuminate\Validation\ValidationException;
class UpdateTask extends BaseService
{
    public function rules(): array
    {
        return [
            'id' => 'exists:tasks,id',
            'title' => 'required',
            'description' => 'required'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data)
    {
        $this->validate($data);
        return Task::findOrFail($data['id'])->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }
}
