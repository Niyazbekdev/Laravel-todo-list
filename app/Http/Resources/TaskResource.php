<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'title' => $this->title,
        'description' => $this->description,
        'is_done' => $this->is_done,
        'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
