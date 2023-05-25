<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\BaseService;
use Illuminate\Validation\ValidationException;
class IsDone extends BaseService
{
    public function rules(): array
    {
        return [
            'id' => 'exists:tasks,id',
            'is_done'=> 'required',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data)
    {
        $this->validate($data);
        return Task::findOrFail($data['id'])->update([
            'is_done' => $data['is_done'],
        ]);
    }
}
