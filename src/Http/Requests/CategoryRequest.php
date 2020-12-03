<?php

namespace Techlink\Blog\Http\Requests;

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
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png|max:512',
            'meta_title' => 'required|max:255',
            'meta_keywords' => 'required|max:255',
            'meta_description' => 'required|max:255'
        ];
    }
}