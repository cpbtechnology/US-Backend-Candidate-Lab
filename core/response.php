<?php
namespace Core;

class Http403 extends \Exception {}
class Http404 extends \Exception {}

class Response {
    protected $status = 200;
    protected $mime = 'text/html';
    protected $headers = [];
    protected $content = '';

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setMimeType($mime) {
        $this->mime = $mime;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setHeader($header, $value) {
        $this->headers[$header] = $value;
    }

    public function __toString() {
        foreach ($this->headers as $header => $value)
            header("${header}: ${value}");
        return $this->content;
    }
}

class JSONResponse extends Response {
    public function __construct($data) {
        $this->content = json_encode($data);
        $this->setMimeType('application/json');
    }
}
