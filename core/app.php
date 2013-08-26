<?php
namespace Core;

require_once 'core/settings.php';
require_once 'core/response.php';

class App {
    private $settings;

    public function __construct($settings_path) {
        $this->settings = new Settings($settings_path);
    }

    public function process($request) {
        try {
            list($controller, $action, $params) = $this->settings->urls->resolve($request->path);
            unshift($params, $request);
            return call_user_func_array([$controller, $action], $params);
        }
        catch (Http404 $e) {
            $response = new Response();
            $response->setStatus(404);
            $response->setBody('Not found');
            return $response;
        }
        catch (Exception $e) {
            return new ExceptionResponse($e);
        }
    }
}
