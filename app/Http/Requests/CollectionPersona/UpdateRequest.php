<?php

namespace App\Http\Requests\CollectionPersona;

use App\Models\Collection;
use App\Models\Taxonomy;
use App\Rules\Base64EncodedPng;
use App\Rules\RootTaxonomyIs;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->isSuperAdmin()) {
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
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'intro' => ['required', 'string', 'min:1', 'max:500'],
            'subtitle' => ['required', 'string', 'min:1', 'max:255'],
            'order' => ['required', 'integer', 'min:1', 'max:'.Collection::personas()->count()],
            'category_taxonomies' => ['present', 'array'],
            'category_taxonomies.*' => ['string', 'exists:taxonomies,id', new RootTaxonomyIs(Taxonomy::NAME_CATEGORY)],
            'image' => ['nullable', 'string', new Base64EncodedPng()],
        ];
    }
}
