<?php

namespace App\Core\Http\Request;

/**
 * @property boolean show_only_mine
 */
class UserableSearchableChunkedListRequest extends SearchableChunkedListRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'show_only_mine' => 'boolean',
        ]);
    }
}
