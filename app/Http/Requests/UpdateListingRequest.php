<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'location' => 'string|max:155',
            'remote' => 'boolean',
            'company_name' => 'string',
            'company_email' => 'string|email',
            'url' => 'string|url',
            'tags' => 'string',
            'description' => 'string',
            'status' => ['string', Rule::in(['draft', 'published'])]
        ];
    }
}
