<?php
namespace Core;

require_once 'core/settings.php';
require_once 'core/response.php';
require_once 'core/model.php';

use Core\Http404;

class App {
    private $settings;

    public function __construct($settings_path) {
        $this->settings = new Settings($settings_path);

        \Core\Model::setDB($this->settings->db);
    }

    public function getSettings() {
        return $this->settings;
    }

    public function process($request) {
        try {
            list($controller, $action, $params) = $this->settings->urls->resolve($request->path);
            # An autoloader should be used here.
            require_once 'app/controllers/' . strtolower($controller) . '.php';
            $controller_class =  '\\App\\Controllers\\' . $controller;
            $controller = new $controller_class($request);
            return call_user_func_array([$controller, $action], $params);
        }
        catch (Http404 $e) {
            $response = new Response();
            $response->setStatus(404);
            $response->setContent('Not found');
            return $response;
        }
        catch (Exception $e) {
            return new ExceptionResponse($e);
        }
    }
}
