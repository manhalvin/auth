<?php

namespace App\Http\Resources;

use App\Models\bookTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class bookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'type_id' => new bookTypesResource(bookTypes::findOrFail($this->type_id)),
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
