<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'title'=>'required|string|max:255',
            'description'=>'string|max:1000',
            'image'=>'image|mimes:jpeg,png,jpg,svg',
            'date'=>'required|date',
            'project_id'=>'required|integer|exists:projects,id',
            'activity_type_id'=>'required|integer|exists:activities_types,id'
        ];
    }
}
