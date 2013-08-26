<?php
namespace Core;

abstract class Controller {
    protected $request;
    protected $db;
    
    public function __construct($request) {
        $this->request = $request;
    }
}
