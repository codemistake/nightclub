<?php

namespace App\Core\Http\Request;

/**
 * @property int limit
 * @property int offset
 */
class ChunkedListRequest extends ApiRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'limit'  => 'integer|min:0|required_with:offset',
            'offset' => 'integer|min:0',
        ]);
    }
}
