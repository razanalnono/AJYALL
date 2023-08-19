<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
      $id =$this->id;
        $rules = [
            'name' => 'required|string',
            'description' => 'string|max:255',
            'link' => 'url',
        ];
      
      if($id >0){
        
        
      }else{
        $rules +=[
            'logo' => 'nullable|mimes:jpg,jpeg,png',
          ];
      }
      return $rules;
        
    }
}