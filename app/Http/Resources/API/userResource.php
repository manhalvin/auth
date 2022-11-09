<?php

namespace App\Http\Resources\API;

use App\Http\Resources\groupResource;
use App\Models\Groups;
use App\Services\API\GroupService;
use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status == 1 ? "Active" : "UnActive",
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'group_name' => $this->group->name,
            'group_id' =>  $this->group->id
        ];
    }
}
