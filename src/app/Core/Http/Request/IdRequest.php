<?php

namespace App\Core\Http\Request;

/**
 * @property int id
 */
class IdRequest extends ApiRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'id' => 'required|integer|min:1'
        ]);
    }

    public function getId(): int
    {
        return (int) $this->input('id');
    }
}
