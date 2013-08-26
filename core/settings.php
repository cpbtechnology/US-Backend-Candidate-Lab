<?php
namespace Core;

class Settings {
    protected $data = [];

    public function __construct($path) {
        $this->data = include $path;
    }

    public function __get($key) {
        if (array_key_exists($key, $this->data))
            return $this->data[$key];
        else
            throw new \Exception('Setting not found: ' . $key);
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }
}
