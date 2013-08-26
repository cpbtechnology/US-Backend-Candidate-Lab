<?php
namespace Core;

class Request {
    protected $get;
    protected $post;
    protected $files;
    protected $method;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function __get($var) {
        if (in_array($var, ['get', 'post', 'files', 'method']))
            return $this->$var;
    }
}
