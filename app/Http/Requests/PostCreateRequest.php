<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['string', 'max:50', 'required'],
            'text' => 'string|nullable',
            'image' => 'file|nullable',
            'access' => 'string|required',
            'commentable' => 'string|required',
        ];
    }
}
