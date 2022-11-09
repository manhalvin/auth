<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required','min:6','unique:posts,title,'. $this->title,
            'content' => 'required|min:6',
            'status' => 'required|integer|between:0,1',
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
}
