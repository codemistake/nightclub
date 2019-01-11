<?php

namespace App\Core\Exception;

abstract class AppException extends \Exception
{
    public static function newInstance(int $code, array $context = [], $data = null)
    {
        return (new static(null, $code))->setContext($context)->setData($data);
    }

    /** @var array Данные для подстановки в текст сообщения */
    protected $context = [];

    /** @var mixed Полезные данные в поле "data" ответа с ошибкой */
    protected $data = null;

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param array $context
     * @return $this
     */
    public function setContext(array $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
