<?php
namespace Core;

require_once 'core/request.php';

abstract class Controller {
    protected $request;
    protected $db;
    
    public function __construct($request) {
        $this->request = $request;
    }

    public function requirePOST() {
        throw new \Core\InvalidRequestMethod;
    }
}
