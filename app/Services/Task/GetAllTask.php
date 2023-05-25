<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\BaseService;
use Illuminate\Validation\ValidationException;
class GetAllTask extends BaseService
{
    public function rules(): array
    {
        return [
            'search' => 'nullable'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data)
    {
        $this->validate($data);
        return Task::with('user')->when($data['search'] ?? null, function($query, $search){
            $query->search($search);
        })->paginate(10);
    }
}
