<?php

namespace Techlink\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'boolean',
            'type' => 'string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,jpg,png|max:512',
            'meta_title' => 'required|max:255',
            'meta_keywords' => 'required|max:255',
            'meta_description' => 'required|max:255'
        ];
    }
}