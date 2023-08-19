<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'string|max:255',
            'budget'=>'numeric',
            'status'=>'string|in:draft,completed,ongoing',
            'start_date'=>'date',
            'end_date'=>'date',
            'image'=>'mimes:jpg,png',
            'partner_id'=>'array|exists:partners,id',
        ];
    }
}