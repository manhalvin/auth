<?php

namespace App\Http\Resources;

use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class postResoure extends JsonResource
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
            'status' => $this->status == 1 ? "Active" : "No Active",
            'book_title' => $this->book->title,
            'user_name' => $this->user->name,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
