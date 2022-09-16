<?php

namespace App\DTO;

class ExtraFilterDTO
{
    public string $key;
    public string $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public static function fromArray($array){
        return new static(array_key_first($array),$array[0]);
    }
    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return ['key' => $this->getKey(), 'value' => $this->getValue()];
    }


}
