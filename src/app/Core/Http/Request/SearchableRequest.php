<?php

namespace App\Core\Http\Request;

/**
 * @property string search_string
 */
class SearchableRequest extends ApiRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'search_string' => 'string',
        ]);
    }
}
