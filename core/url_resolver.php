<?php
namespace Core;

class Http404 extends \Exception {}

class URLResolver {
    protected $patterns;

    public function __construct($patterns) {
        $this->patterns = $patterns;
    }

    public function resolve($url) {
        foreach ($this->patterns as $pattern => $data)
            if (preg_match($pattern, $url, $matches))
                return $data + [$matches];
        throw new Http404();
    }
}
