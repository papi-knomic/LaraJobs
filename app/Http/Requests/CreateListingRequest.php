<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateListingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:155',
            'company_name' => 'required|string',
            'company_email' => 'required|string|email',
            'url' => 'required|string|url',
            'tags' => 'required|string',
            'description' => 'required|string|max:255',
            'status' => ['string', Rule::in(['draft', 'published'])]
        ];
    }
}
