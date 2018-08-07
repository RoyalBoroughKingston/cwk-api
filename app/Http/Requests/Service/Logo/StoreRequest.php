<?php

namespace App\Http\Requests\Service\Logo;

use App\Rules\Base64EncodedPng;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $service = $this->route('service');

        if ($this->user()->isServiceAdmin($service)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'string', new Base64EncodedPng()],
        ];
    }
}
