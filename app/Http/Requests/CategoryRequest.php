<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code'=>'required|min:3|max:55|unique:categories,code',
            'name'=>'required|min:3|max:155',
            'description'=>'required|min:5'
        ];

        if($this->route()->named('categories.update')){
            $rules['code'].=','.$this->route()->parameter('category')->id;
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'required'=>'Поле :attribute обязательно для заполнения',
            'min'=>'Минимальное количество символов :min',
            ];
    }
}
