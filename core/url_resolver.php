<?php
namespace Core;

class URLResolver {
    protected $patterns;

    public function __construct($patterns) {
        $this->patterns = $patterns;
    }

    public function resolve($url) {
        foreach ($this->patterns as $pattern => $data)
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                return array_merge($data, [$matches]);
            }
        throw new Http404();
    }
}
