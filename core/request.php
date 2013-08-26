<?php
namespace Core;

class InvalidRequestMethod extends \Exception {}

class Request {
    protected $get;
    protected $post;
    protected $files;
    protected $method;

    public function __construct($root_url) {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = '/' . $_GET['_path'];
    }

    public function __get($var) {
        if (in_array($var, ['get', 'post', 'files', 'method']))
            return $this->$var;
    }
}
