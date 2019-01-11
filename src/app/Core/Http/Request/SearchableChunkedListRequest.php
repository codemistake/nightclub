<?php

namespace App\Core\Http\Request;

/**
 * @property string search_string
 */
class SearchableChunkedListRequest extends ChunkedListRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'search_string' => 'string',
        ]);
    }
}
