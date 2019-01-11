<?php

namespace App\Core\Http\Request;


abstract class ApiRequest extends ValidatableRequest
{
    public function getSanitizedValue($key, $default = null)
    {
        $value = $this->get($key, $default);

        if ($value !== null) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $value = str_replace(['+', '%', '_'], ['\+', '\%', '\_'], $value);
        }

        return $value;
    }
}
