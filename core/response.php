<?php
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

    public function __toString() {
        foreach ($headers as $header)
            header($header);
        return $self->content;
    }
}
